<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageOptimizer
{
    /**
     * Compress and optimize an uploaded image file, saving it to storage/app/public.
     *
     * @param UploadedFile|string $file Source uploaded file or absolute file path
     * @param string $directory Subfolder inside storage/app/public (e.g. 'work-orders')
     * @param int $maxDimension Maximum width or height in pixels
     * @param int $quality JPEG quality (1-100)
     * @return string Relative path stored under storage/app/public (e.g. 'work-orders/6652a1b9.jpg')
     */
    public static function optimizeAndStore($file, string $directory = 'work-orders', int $maxDimension = 1920, int $quality = 82): string
    {
        $sourcePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;
        $extension = strtolower($file instanceof UploadedFile ? $file->getClientOriginalExtension() : pathinfo($sourcePath, PATHINFO_EXTENSION));

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $extension = 'jpg';
        }

        $fileName = $directory . '/' . uniqid() . '.' . $extension;
        $targetDirectory = storage_path('app/public/' . $directory);

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $targetFullPath = storage_path('app/public/' . $fileName);

        try {
            if (extension_loaded('gd') && file_exists($sourcePath)) {
                $imageInfo = @getimagesize($sourcePath);
                if ($imageInfo) {
                    $mime = $imageInfo[0] ? $imageInfo['mime'] : '';
                    $srcImg = null;

                    switch ($mime) {
                        case 'image/jpeg':
                            $srcImg = @imagecreatefromjpeg($sourcePath);
                            break;
                        case 'image/png':
                            $srcImg = @imagecreatefrompng($sourcePath);
                            break;
                        case 'image/webp':
                            $srcImg = @imagecreatefromwebp($sourcePath);
                            break;
                    }

                    if ($srcImg) {
                        // Fix EXIF orientation for smartphones
                        if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
                            $exif = @exif_read_data($sourcePath);
                            if (!empty($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 3:
                                        $srcImg = imagerotate($srcImg, 180, 0);
                                        break;
                                    case 6:
                                        $srcImg = imagerotate($srcImg, -90, 0);
                                        break;
                                    case 8:
                                        $srcImg = imagerotate($srcImg, 90, 0);
                                        break;
                                }
                            }
                        }

                        $origWidth = imagesx($srcImg);
                        $origHeight = imagesy($srcImg);

                        // Calculate new dimensions preserving aspect ratio
                        if ($origWidth > $maxDimension || $origHeight > $maxDimension) {
                            if ($origWidth >= $origHeight) {
                                $newWidth = $maxDimension;
                                $newHeight = (int) round(($origHeight / $origWidth) * $maxDimension);
                            } else {
                                $newHeight = $maxDimension;
                                $newWidth = (int) round(($origWidth / $origHeight) * $maxDimension);
                            }
                        } else {
                            $newWidth = $origWidth;
                            $newHeight = $origHeight;
                        }

                        $dstImg = imagecreatetruecolor($newWidth, $newHeight);

                        // Preserve transparency for PNG / WebP
                        if (in_array($mime, ['image/png', 'image/webp'])) {
                            imagealphablending($dstImg, false);
                            imagesavealpha($dstImg, true);
                        }

                        imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

                        // Save optimized file
                        if ($extension === 'png') {
                            // PNG compression range 0-9
                            $pngQuality = (int) round((100 - $quality) / 10);
                            imagepng($dstImg, $targetFullPath, max(0, min(9, $pngQuality)));
                        } elseif ($extension === 'webp') {
                            imagewebp($dstImg, $targetFullPath, $quality);
                        } else {
                            imagejpeg($dstImg, $targetFullPath, $quality);
                        }

                        imagedestroy($srcImg);
                        imagedestroy($dstImg);

                        return $fileName;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Log error silently and fall back to direct file copy
            logger()->error('Image optimization failed: ' . $e->getMessage());
        }

        // Fallback: direct copy if GD processing failed
        copy($sourcePath, $targetFullPath);

        return $fileName;
    }
}
