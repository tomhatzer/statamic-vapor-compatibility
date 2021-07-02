<?php

namespace StatamicVaporCompatibility\Tools;

use Illuminate\Support\Facades\Storage;
use function str_replace;

class TemporaryStorage
{
    public const TEMP_DISK_NAME = 'tempDirectory';

    public static function storage_path(string $path): string
    {
        $storageBasePath = storage_path('/');
        $storagePath = storage_path($path);

        $newPath = str_replace($storageBasePath, Storage::disk(self::TEMP_DISK_NAME)->path('/'), $storagePath);

        if(! Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->exists($path)) {
            Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->makeDirectory('content', true);
        }

        return $newPath;
    }

    public static function public_path(string $path): string
    {
        $publicBasePath = public_path('/');
        $publicPath = public_path($path);

        return str_replace($publicBasePath, Storage::disk(self::TEMP_DISK_NAME)->path('/'), $publicPath);
    }

    public static function resource_path(string $path): string
    {
        $resourceBasePath = resource_path('/');
        $resourcePath = resource_path($path);

        return str_replace($resourceBasePath, Storage::disk(self::TEMP_DISK_NAME)->path('/'), $resourcePath);
    }

    public static function base_path(string $path): string
    {
        $baseBasePath = base_path('/');
        $basePath = base_path($path);

        return str_replace($baseBasePath, Storage::disk(self::TEMP_DISK_NAME)->path('/'), $basePath);
    }
}
