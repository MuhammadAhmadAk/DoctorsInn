<?php

namespace App\Services;

/**
 * MP4 Fast Start Optimizer (Pure PHP — No FFmpeg Required)
 *
 * Moves the MP4 'moov' atom (metadata) to the beginning of the file so
 * browsers can start streaming/playing video before the full file is downloaded.
 *
 * This is equivalent to: ffmpeg -movflags faststart
 *
 * Works on:
 *   - Standard MP4 (.mp4, .m4v)
 *   - MOV containers (.mov)
 *   - 32-bit (stco) and 64-bit (co64) chunk offset tables
 *
 * Not supported:
 *   - Fragmented MP4 (fMP4 / DASH segments) — already optimized by nature
 *   - WebM / MKV — different container format, no moov atom
 */
class Mp4FastStartService
{
    private const CHUNK_SIZE = 1_048_576; // 1 MB read/write buffer

    /**
     * Optimize an MP4 file in-place (overwrites original after processing).
     *
     * @param  string  $filePath  Absolute path to the uploaded video file.
     * @return array{optimized: bool, reason: string}
     */
    public function optimize(string $filePath): array
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Only attempt on MP4/MOV containers — WebM/MKV are already streamable
        if (!in_array($ext, ['mp4', 'm4v', 'mov', 'qt'], true)) {
            return ['optimized' => false, 'reason' => 'skipped (non-MP4 container)'];
        }

        if (!file_exists($filePath) || !is_readable($filePath)) {
            return ['optimized' => false, 'reason' => 'file not readable'];
        }

        $tmpPath = $filePath . '.faststart.tmp';

        try {
            $result = $this->makeFastStart($filePath, $tmpPath);

            if ($result['success']) {
                // Atomically replace original file with optimized version
                rename($tmpPath, $filePath);
                return ['optimized' => true, 'reason' => $result['reason']];
            }

            // Clean up temp file on failure
            if (file_exists($tmpPath)) {
                @unlink($tmpPath);
            }

            return ['optimized' => false, 'reason' => $result['reason']];

        } catch (\Throwable $e) {
            if (file_exists($tmpPath)) {
                @unlink($tmpPath);
            }
            return ['optimized' => false, 'reason' => 'exception: ' . $e->getMessage()];
        }
    }

    // =========================================================================
    // INTERNAL IMPLEMENTATION
    // =========================================================================

    private function makeFastStart(string $inputPath, string $outputPath): array
    {
        $fileSize = filesize($inputPath);
        if ($fileSize === false || $fileSize < 16) {
            return ['success' => false, 'reason' => 'file too small or unreadable'];
        }

        $in = fopen($inputPath, 'rb');
        if (!$in) {
            return ['success' => false, 'reason' => 'cannot open input file'];
        }

        // ---- Phase 1: Parse top-level atom list ----
        $atoms  = [];
        $offset = 0;

        while ($offset < $fileSize) {
            if (fseek($in, $offset) !== 0) {
                break;
            }

            $header = fread($in, 8);
            if (strlen($header) < 8) {
                break;
            }

            $unpacked    = unpack('Nsize/a4type', $header);
            $atomSize    = (int) $unpacked['size'];
            $atomType    = $unpacked['type'];
            $headerBytes = 8;

            if ($atomSize === 1) {
                // 64-bit extended size atom
                $extHeader = fread($in, 8);
                if (strlen($extHeader) < 8) {
                    break;
                }
                $hi       = unpack('N', substr($extHeader, 0, 4))[1];
                $lo       = unpack('N', substr($extHeader, 4, 4))[1];
                $atomSize = ($hi << 32) | $lo;
                $headerBytes = 16;
            } elseif ($atomSize === 0) {
                // Atom runs to end-of-file
                $atomSize = $fileSize - $offset;
            }

            if ($atomSize < 8 || $offset + $atomSize > $fileSize + 1) {
                // Corrupt / truncated atom — stop parsing
                break;
            }

            $atoms[$atomType] = [
                'offset'      => $offset,
                'size'        => $atomSize,
                'headerBytes' => $headerBytes,
            ];

            $offset += $atomSize;
        }

        // ---- Phase 2: Validate required atoms ----
        if (!isset($atoms['moov'], $atoms['mdat'])) {
            fclose($in);
            return ['success' => false, 'reason' => 'missing moov or mdat atom — not a valid MP4'];
        }

        $moov = $atoms['moov'];
        $mdat = $atoms['mdat'];

        // Already fast-start: moov is before mdat — just copy unchanged
        if ($moov['offset'] < $mdat['offset']) {
            fclose($in);
            $this->copyFile($inputPath, $outputPath);
            return ['success' => true, 'reason' => 'already faststart — copied unchanged'];
        }

        // ---- Phase 3: Read the moov atom entirely into memory ----
        // Large moov atoms (>256 MB) are unusual but we guard memory anyway
        $memLimit = $this->getMemoryHeadroom();
        if ($moov['size'] > $memLimit) {
            fclose($in);
            return ['success' => false, 'reason' => 'moov atom too large for available PHP memory'];
        }

        fseek($in, $moov['offset']);
        $moovData = fread($in, $moov['size']);
        if (strlen($moovData) !== $moov['size']) {
            fclose($in);
            return ['success' => false, 'reason' => 'could not read moov atom completely'];
        }

        // ---- Phase 4: Patch chunk offsets inside moov ----
        // Moving moov to the front pushes mdat forward by moov['size'] bytes
        // (minus ftyp which stays at position 0 — ftyp was already before moov).
        // The shift equals the size of the moov atom itself.
        $shiftBytes = (int) $moov['size'];

        // If ftyp is present and was before moov, we write ftyp first (no shift needed for ftyp)
        // but mdat and other non-ftyp/non-moov atoms shift by moov['size'].
        // Detailed: new order is [ftyp?][moov][free?][mdat] — only atoms after the new moov position shift.
        // For standard layouts the shift equals moov size exactly.
        $this->patchChunkOffsets($moovData, $shiftBytes);

        // ---- Phase 5: Write optimized output file ----
        $out = fopen($outputPath, 'wb');
        if (!$out) {
            fclose($in);
            return ['success' => false, 'reason' => 'cannot open output file for writing'];
        }

        // Write atoms in Fast-Start order:
        // 1. ftyp (file type — must stay first)
        if (isset($atoms['ftyp'])) {
            fseek($in, $atoms['ftyp']['offset']);
            $this->streamCopy($in, $out, $atoms['ftyp']['size']);
        }

        // 2. moov (now patched — moved to front)
        fwrite($out, $moovData);
        unset($moovData); // free RAM immediately

        // 3. All remaining atoms in original order (skip ftyp and moov already written)
        $skipTypes = ['ftyp', 'moov'];
        $orderedAtoms = $atoms;
        uasort($orderedAtoms, fn($a, $b) => $a['offset'] <=> $b['offset']);

        foreach ($orderedAtoms as $type => $atom) {
            if (in_array($type, $skipTypes, true)) {
                continue;
            }
            fseek($in, $atom['offset']);
            $this->streamCopy($in, $out, $atom['size']);
        }

        fclose($in);
        fclose($out);

        return ['success' => true, 'reason' => 'moov atom relocated to front — fast start applied'];
    }

    /**
     * Recursively scan moov atom binary and shift all stco/co64 chunk offset pointers.
     */
    private function patchChunkOffsets(string &$data, int $shift): void
    {
        $len = strlen($data);
        $pos = 0;

        while ($pos < $len - 8) {
            $header  = substr($data, $pos, 8);
            $unpk    = unpack('Nsize/a4type', $header);
            $boxSize = (int) $unpk['size'];
            $boxType = $unpk['type'];

            if ($boxSize < 8 || $pos + $boxSize > $len) {
                $pos++;
                continue;
            }

            if ($boxType === 'stco') {
                // 32-bit chunk offsets
                // Layout: [4 version/flags][4 entry_count][N × 4 offsets]
                $countOffset  = $pos + 12;
                $entryCount   = unpack('N', substr($data, $countOffset, 4))[1];
                $dataStart    = $pos + 16;

                for ($i = 0; $i < $entryCount; $i++) {
                    $p = $dataStart + ($i * 4);
                    if ($p + 4 > $len) {
                        break;
                    }
                    $orig    = unpack('N', substr($data, $p, 4))[1];
                    $patched = $orig + $shift;
                    $data    = substr_replace($data, pack('N', $patched), $p, 4);
                }

            } elseif ($boxType === 'co64') {
                // 64-bit chunk offsets
                // Layout: [4 version/flags][4 entry_count][N × 8 offsets]
                $countOffset = $pos + 12;
                $entryCount  = unpack('N', substr($data, $countOffset, 4))[1];
                $dataStart   = $pos + 16;

                for ($i = 0; $i < $entryCount; $i++) {
                    $p = $dataStart + ($i * 8);
                    if ($p + 8 > $len) {
                        break;
                    }
                    $hi   = unpack('N', substr($data, $p, 4))[1];
                    $lo   = unpack('N', substr($data, $p + 4, 4))[1];
                    $orig = ($hi << 32) | $lo;

                    $patched  = $orig + $shift;
                    $newHi    = ($patched >> 32) & 0xFFFFFFFF;
                    $newLo    = $patched & 0xFFFFFFFF;
                    $data     = substr_replace($data, pack('N', $newHi) . pack('N', $newLo), $p, 8);
                }

            } elseif (in_array($boxType, ['moov', 'trak', 'edts', 'mdia', 'minf', 'stbl', 'udta', 'mvex', 'dinf'], true)) {
                // Container boxes — recurse into inner content (skip 8-byte box header)
                $innerOffset = $pos + 8;
                $innerLen    = $boxSize - 8;
                if ($innerLen > 0 && $innerOffset + $innerLen <= $len) {
                    $inner = substr($data, $innerOffset, $innerLen);
                    $this->patchChunkOffsets($inner, $shift);
                    $data  = substr_replace($data, $inner, $innerOffset, $innerLen);
                }
            }

            $pos += $boxSize;
        }
    }

    /**
     * Stream-copy $bytes from $in to $out in 1 MB chunks (RAM safe for large files).
     */
    private function streamCopy($in, $out, int $bytes): void
    {
        $remaining = $bytes;
        while ($remaining > 0) {
            $toRead = min($remaining, self::CHUNK_SIZE);
            $buffer = fread($in, $toRead);
            if ($buffer === false || $buffer === '') {
                break;
            }
            fwrite($out, $buffer);
            $remaining -= strlen($buffer);
        }
    }

    /**
     * Copy a file in 1 MB chunks (stream-safe for large videos).
     */
    private function copyFile(string $src, string $dst): void
    {
        $in  = fopen($src, 'rb');
        $out = fopen($dst, 'wb');
        if (!$in || !$out) {
            return;
        }
        $this->streamCopy($in, $out, filesize($src));
        fclose($in);
        fclose($out);
    }

    /**
     * Return approximate available PHP memory headroom in bytes.
     * We refuse to load a moov atom that would exhaust memory.
     */
    private function getMemoryHeadroom(): int
    {
        $limit = ini_get('memory_limit');
        if ($limit === '-1') {
            return PHP_INT_MAX;
        }

        $unit  = strtolower(substr($limit, -1));
        $value = (int) $limit;

        $bytes = match ($unit) {
            'g'     => $value * 1_073_741_824,
            'm'     => $value * 1_048_576,
            'k'     => $value * 1_024,
            default => $value,
        };

        $used = memory_get_usage(true);
        // Keep 64 MB buffer for PHP itself
        return max(0, $bytes - $used - 67_108_864);
    }
}
