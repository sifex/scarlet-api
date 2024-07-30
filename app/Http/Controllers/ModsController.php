<?php

namespace App\Http\Controllers;

use Cache;
use Config;
use Corbpie\BunnyCdn\BunnyAPIPull;
use Illuminate\Http\JsonResponse;
use League\Flysystem\FilesystemException;
use Storage;
use Str;

class ModsController extends Controller
{
    public const MODS_PREFIX = '@Mods_AAF';

    public const CACHE_TTL = 3600 * 2;

    public function get_mods(): JsonResponse
    {
        if (Cache::has('mods')) {
            return response()->json(
                self::format_files(
                    Cache::get('mods') ?? [],
                    Config::get('filesystems.disks.bunnycdn.pull_zone_url')
                )
            );
        }


        return response()->json(
            $this->regenerate_mods()
        );
    }

    /**
     * @throws \Throwable
     * @throws FilesystemException
     */
    public function regenerate_mods(): JsonResponse
    {
        /**
         * Get all files from BunnyCDN and cache them
         */
        $files = Storage::disk('bunnycdn')->getDriver()->listContents('', true)->toArray();

        $ttl = now()->addSeconds(self::CACHE_TTL);
        Cache::put('mods', $files, $ttl);
        Cache::put('mods_ttl', $ttl);

        /**
         * Purge BunnyCDN cache
         */
        throw_if($this->purge_bunnycdn_cache() != [], 'Failed to purge BunnyCDN cache');

        return response()->json(
            self::format_files(
                $files,
                Config::get('filesystems.disks.bunnycdn.pull_zone_url')
            )
        );
    }

    private static function format_files(array $files, string $pull_zone_url = ''): array
    {
        return collect($files)
            ->filter(fn ($file) => $file['type'] === 'file')
            ->map(fn ($file) => [
                'url' => Str::finish($pull_zone_url, '/') . $file['path'],
                'path' => Str::finish(self::MODS_PREFIX, '/') . $file['path'],
                'sha256_hash' => Str::lower($file['extra_metadata']['checksum']),
            ])->values()->toArray();
    }

    private function purge_bunnycdn_cache(): array
    {
        $bunny = new BunnyAPIPull();
        $bunny->apiKey(Config::get('bunnycdn.api_key'));
        return $bunny->purgePullZone(
            Config::get('bunnycdn.pull_zone_id'),
        );
    }
}
