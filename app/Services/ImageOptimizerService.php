<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Subfolder-specific dimension, quality, and byte-budget presets.
     *
     * @var array<string, array{maxWidth:int, maxHeight:int, quality:int, minQuality:int, targetBytes:int}>
     */
    private const PRESETS = [
        'testimonials' => ['maxWidth' => 400,  'maxHeight' => 400,  'quality' => 80, 'minQuality' => 62, 'targetBytes' => 35 * 1024],
        'instructors'  => ['maxWidth' => 800,  'maxHeight' => 900,  'quality' => 80, 'minQuality' => 62, 'targetBytes' => 65 * 1024],
        'courses'      => ['maxWidth' => 1200, 'maxHeight' => 900,  'quality' => 80, 'minQuality' => 64, 'targetBytes' => 95 * 1024],
        'blogs'        => ['maxWidth' => 1200, 'maxHeight' => 900,  'quality' => 80, 'minQuality' => 64, 'targetBytes' => 95 * 1024],
        'cms'          => ['maxWidth' => 1600, 'maxHeight' => 1600, 'quality' => 80, 'minQuality' => 64, 'targetBytes' => 120 * 1024],
    ];

    /**
     * Store and deep-optimize an uploaded image under public/uploads/{subfolder}.
     * Resizes oversized assets, auto-orients camera EXIF rotation, strips metadata,
     * preserves alpha transparency, and adaptively encodes to target-sized WebP.
     */
    public static function storeOptimized(?UploadedFile $file, string $subfolder = 'cms', array $options = []): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $cleanSubfolder = trim($subfolder, '/') ?: 'cms';
        $targetDir = public_path('uploads/' . $cleanSubfolder);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'jpg'));
        $safeBase = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'media';
        $uniquePrefix = $safeBase . '-' . time() . '-' . Str::random(5);

        $preset = array_merge(
            self::PRESETS[$cleanSubfolder] ?? [
                'maxWidth' => 1400,
                'maxHeight' => 1400,
                'quality' => 80,
                'minQuality' => 64,
                'targetBytes' => 100 * 1024,
            ],
            $options
        );

        $sourcePath = $file->getRealPath();

        if ($ext === 'svg' && $sourcePath) {
            $svgFilename = $uniquePrefix . '.svg';
            if (self::storeOptimizedSvg($sourcePath, $targetDir . DIRECTORY_SEPARATOR . $svgFilename)) {
                return 'uploads/' . $cleanSubfolder . '/' . $svgFilename;
            }
        }

        if ($sourcePath && self::shouldOptimizeRaster($sourcePath, $ext)) {
            $webpFilename = $uniquePrefix . '.webp';
            $webpPath = $targetDir . DIRECTORY_SEPARATOR . $webpFilename;

            if (self::optimizeToWebpWithBudget(
                $sourcePath,
                $webpPath,
                $ext,
                $preset['maxWidth'],
                $preset['maxHeight'],
                $preset['quality'],
                $preset['minQuality'],
                $preset['targetBytes']
            )) {
                $origSize = @filesize($sourcePath) ?: 0;
                $newSize = @filesize($webpPath) ?: 0;

                if ($ext === 'webp' && $origSize > 0 && $newSize >= $origSize) {
                    @unlink($webpPath);
                } elseif ($newSize > 0) {
                    return 'uploads/' . $cleanSubfolder . '/' . $webpFilename;
                } else {
                    @unlink($webpPath);
                }
            }
        }

        $fallbackFilename = $uniquePrefix . '.' . $ext;
        $file->move($targetDir, $fallbackFilename);

        return 'uploads/' . $cleanSubfolder . '/' . $fallbackFilename;
    }

    /**
     * Strip redundant XML comments and editor whitespace from uploaded SVG assets.
     */
    private static function storeOptimizedSvg(string $sourcePath, string $destPath): bool
    {
        $raw = @file_get_contents($sourcePath);
        if ($raw === false || stripos($raw, '<svg') === false) {
            return false;
        }

        $cleaned = preg_replace('/<!--[\s\S]*?-->/', '', $raw) ?? $raw;
        $cleaned = preg_replace('/\s{2,}/', ' ', $cleaned) ?? $cleaned;
        $cleaned = preg_replace('/>\s+</', '><', $cleaned) ?? $cleaned;
        $cleaned = trim($cleaned);

        return @file_put_contents($destPath, strlen($cleaned) < strlen($raw) ? $cleaned : $raw) !== false;
    }

    /**
     * Skip SVG vectors and animated GIFs so vector crispness or frame animations stay intact.
     */
    private static function shouldOptimizeRaster(string $path, string $ext): bool
    {
        if ($ext === 'svg') {
            return false;
        }

        if ($ext === 'gif' && self::isAnimatedGif($path)) {
            return false;
        }

        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'avif'], true);
    }

    /**
     * Detect multi-frame animated GIFs by counting graphic control extensions.
     */
    private static function isAnimatedGif(string $path): bool
    {
        $fh = @fopen($path, 'rb');
        if (!$fh) {
            return false;
        }

        $count = 0;
        while (!feof($fh) && $count < 2) {
            $chunk = fread($fh, 1024 * 100);
            if ($chunk === false) {
                break;
            }
            $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00[\x2C\x21]#s', $chunk);
        }
        fclose($fh);

        return $count > 1;
    }

    /**
     * Deep-optimize raster images using Imagick (libwebp method=6 + adaptive target byte budget)
     * first, with PHP GD as automatic fallback.
     */
    private static function optimizeToWebpWithBudget(
        string $sourcePath,
        string $destPath,
        string $ext,
        int $maxWidth,
        int $maxHeight,
        int $startQuality,
        int $minQuality,
        int $targetBytes
    ): bool {
        if (extension_loaded('imagick')) {
            if (self::optimizeWithImagick($sourcePath, $destPath, $maxWidth, $maxHeight, $startQuality, $minQuality, $targetBytes)) {
                return true;
            }
        }

        if (extension_loaded('gd') && function_exists('imagewebp')) {
            return self::optimizeWithGd($sourcePath, $destPath, $ext, $maxWidth, $maxHeight, $startQuality, $minQuality, $targetBytes);
        }

        return false;
    }

    /**
     * Optimize via Imagick with Lanczos downscaling, EXIF stripping, method=6 WebP compression,
     * and adaptive quality step-down until the output fits the target byte budget.
     */
    private static function optimizeWithImagick(
        string $sourcePath,
        string $destPath,
        int $maxWidth,
        int $maxHeight,
        int $startQuality,
        int $minQuality,
        int $targetBytes
    ): bool {
        try {
            $im = new \Imagick($sourcePath);
            if (method_exists($im, 'autoOrient')) {
                $im->autoOrient();
            }

            $w = $im->getImageWidth();
            $h = $im->getImageHeight();
            if ($w > $maxWidth || $h > $maxHeight) {
                $im->resizeImage($maxWidth, $maxHeight, \Imagick::FILTER_LANCZOS, 1, true);
            }

            $im->stripImage();
            $im->setImageFormat('webp');
            $im->setOption('webp:method', '6');
            $im->setOption('webp:auto-filter', 'true');
            $im->setOption('webp:alpha-quality', '90');

            $quality = $startQuality;
            while (true) {
                $im->setImageCompressionQuality($quality);
                if (!$im->writeImage($destPath)) {
                    $im->clear();
                    return false;
                }

                clearstatcache(true, $destPath);
                $size = @filesize($destPath) ?: 0;
                if ($size <= $targetBytes || $quality <= $minQuality) {
                    break;
                }

                $quality = max($minQuality, $quality - 6);
            }

            $im->clear();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Optimize via PHP GD with EXIF orientation normalization, truecolor alpha support,
     * and iterative quality tuning until the output fits the target byte budget.
     */
    private static function optimizeWithGd(
        string $sourcePath,
        string $destPath,
        string $ext,
        int $maxWidth,
        int $maxHeight,
        int $startQuality,
        int $minQuality,
        int $targetBytes
    ): bool {
        try {
            $src = null;
            if ($ext === 'avif' && function_exists('imagecreatefromavif')) {
                $src = @imagecreatefromavif($sourcePath);
            } else {
                $raw = @file_get_contents($sourcePath);
                if ($raw === false) {
                    return false;
                }
                $src = @imagecreatefromstring($raw);
                unset($raw);
            }

            if (!$src) {
                return false;
            }

            if (in_array($ext, ['jpg', 'jpeg'], true)) {
                $src = self::applyExifOrientationGd($src, $sourcePath);
            }

            if (function_exists('imagepalettetotruecolor')) {
                @imagepalettetotruecolor($src);
            }

            $origW = imagesx($src);
            $origH = imagesy($src);
            if ($origW <= 0 || $origH <= 0) {
                return false;
            }

            $scale = min(1.0, $maxWidth / $origW, $maxHeight / $origH);
            $newW = max(1, (int) round($origW * $scale));
            $newH = max(1, (int) round($origH * $scale));

            $dst = imagecreatetruecolor($newW, $newH);
            if (!$dst) {
                return false;
            }

            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $newW, $newH, $transparent);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            unset($src);

            $ok = false;
            $quality = $startQuality;
            while (true) {
                $ok = (bool) @imagewebp($dst, $destPath, $quality);
                if (!$ok) {
                    break;
                }

                clearstatcache(true, $destPath);
                $size = @filesize($destPath) ?: 0;
                if ($size <= $targetBytes || $quality <= $minQuality) {
                    break;
                }

                $quality = max($minQuality, $quality - 6);
            }

            unset($dst);
            return $ok;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Correct orientation for camera JPEGs before resampling so portraits stay upright.
     */
    private static function applyExifOrientationGd($image, string $sourcePath)
    {
        if (!function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($sourcePath);
        $orientation = (int) ($exif['Orientation'] ?? 1);
        $angle = match ($orientation) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => 0,
        };

        if ($angle !== 0) {
            $rotated = @imagerotate($image, $angle, 0);
            if ($rotated) {
                return $rotated;
            }
        }

        return $image;
    }
}
