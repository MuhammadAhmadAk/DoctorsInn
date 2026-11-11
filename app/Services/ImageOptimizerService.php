<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Subfolder-specific dimension & quality presets so every section gets appropriately sized WebP assets.
     *
     * @var array<string, array{maxWidth:int, maxHeight:int, quality:int}>
     */
    private const PRESETS = [
        'testimonials' => ['maxWidth' => 400,  'maxHeight' => 400,  'quality' => 82],
        'instructors'  => ['maxWidth' => 800,  'maxHeight' => 900,  'quality' => 82],
        'courses'      => ['maxWidth' => 1200, 'maxHeight' => 900,  'quality' => 82],
        'blogs'        => ['maxWidth' => 1200, 'maxHeight' => 900,  'quality' => 82],
        'cms'          => ['maxWidth' => 1600, 'maxHeight' => 1600, 'quality' => 82],
    ];

    /**
     * Store and automatically optimize an uploaded image under public/uploads/{subfolder}.
     * Resizes oversized raster uploads, corrects EXIF orientation, preserves alpha transparency,
     * and converts to lightweight WebP when supported by GD or Imagick.
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
            self::PRESETS[$cleanSubfolder] ?? ['maxWidth' => 1400, 'maxHeight' => 1400, 'quality' => 82],
            $options
        );

        $sourcePath = $file->getRealPath();
        if ($sourcePath && self::shouldOptimizeRaster($sourcePath, $ext)) {
            $webpFilename = $uniquePrefix . '.webp';
            $webpPath = $targetDir . DIRECTORY_SEPARATOR . $webpFilename;

            if (self::optimizeToWebp($sourcePath, $webpPath, $ext, $preset['maxWidth'], $preset['maxHeight'], $preset['quality'])) {
                $origSize = @filesize($sourcePath) ?: 0;
                $newSize = @filesize($webpPath) ?: 0;

                // Keep whichever is smaller if the original was already a tiny optimized WebP
                if ($ext === 'webp' && $origSize > 0 && $newSize >= $origSize) {
                    @unlink($webpPath);
                } elseif ($newSize > 0) {
                    return 'uploads/' . $cleanSubfolder . '/' . $webpFilename;
                } else {
                    @unlink($webpPath);
                }
            }
        }

        // Passthrough fallback for SVG, animated GIF, or environments without GD/Imagick
        $fallbackFilename = $uniquePrefix . '.' . $ext;
        $file->move($targetDir, $fallbackFilename);

        return 'uploads/' . $cleanSubfolder . '/' . $fallbackFilename;
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
     * Convert and resize source image to WebP using GD first, falling back to Imagick when needed.
     */
    private static function optimizeToWebp(
        string $sourcePath,
        string $destPath,
        string $ext,
        int $maxWidth,
        int $maxHeight,
        int $quality
    ): bool {
        if (extension_loaded('gd') && function_exists('imagewebp')) {
            if (self::optimizeWithGd($sourcePath, $destPath, $ext, $maxWidth, $maxHeight, $quality)) {
                return true;
            }
        }

        if (extension_loaded('imagick')) {
            return self::optimizeWithImagick($sourcePath, $destPath, $maxWidth, $maxHeight, $quality);
        }

        return false;
    }

    /**
     * Optimize raster image using PHP GD with EXIF orientation normalization and alpha support.
     */
    private static function optimizeWithGd(
        string $sourcePath,
        string $destPath,
        string $ext,
        int $maxWidth,
        int $maxHeight,
        int $quality
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

            $ok = @imagewebp($dst, $destPath, $quality);
            unset($dst);

            return (bool) $ok;
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

    /**
     * Fallback WebP optimizer using Imagick when GD cannot decode an input format.
     */
    private static function optimizeWithImagick(
        string $sourcePath,
        string $destPath,
        int $maxWidth,
        int $maxHeight,
        int $quality
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
            $im->setImageCompressionQuality($quality);
            $ok = $im->writeImage($destPath);
            $im->clear();

            return (bool) $ok;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
