<?php

namespace App\Support\Cms;

use App\Rules\CmsGalleryMediaFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CmsGalleryMedia
{
    public const IMAGE_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    public const VIDEO_MIME_TYPES = [
        'video/mp4',
        'video/webm',
        'video/quicktime',
        'video/x-msvideo',
    ];

    public const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public const VIDEO_EXTENSIONS = ['mp4', 'webm', 'mov', 'avi'];

    public const IMAGE_MAX_KB = 2048;

    public const VIDEO_MAX_KB = 51200;

    public static function allMimeTypes(): array
    {
        return array_merge(self::IMAGE_MIME_TYPES, self::VIDEO_MIME_TYPES);
    }

    public static function allExtensions(): array
    {
        return array_merge(self::IMAGE_EXTENSIONS, self::VIDEO_EXTENSIONS);
    }

    public static function fileRule(): CmsGalleryMediaFile
    {
        return new CmsGalleryMediaFile();
    }

    public static function isImageMime(?string $mime): bool
    {
        return in_array(strtolower((string) $mime), self::IMAGE_MIME_TYPES, true);
    }

    public static function isVideoMime(?string $mime): bool
    {
        return in_array(strtolower((string) $mime), self::VIDEO_MIME_TYPES, true);
    }

    public static function isImage(Media $media): bool
    {
        return self::isImageMime($media->mime_type);
    }

    public static function isVideo(Media $media): bool
    {
        return self::isVideoMime($media->mime_type);
    }

    public static function previewUrl(Media $media): string
    {
        if (self::isVideo($media)) {
            return $media->getUrl();
        }

        return $media->getUrl('thumb') ?: $media->getUrl();
    }
}
