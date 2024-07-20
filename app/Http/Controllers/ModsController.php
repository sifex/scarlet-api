<?php

namespace App\Http\Controllers;

use App\User;
use Cache;
use Config;
use FluidXml\FluidXml;
use Illuminate\Http\JsonResponse;
use Storage;
use Str;

class ModsController extends Controller
{
    const MODS_PREFIX = '@Mods_AAF';

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

    public function regenerate_mods(): JsonResponse
    {
        $files = Storage::disk('bunnycdn')->getDriver()->listContents('', true)->toArray();

        Cache::put('mods', $files);

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
            ->filter(fn($file) => $file['type'] === 'file')
            ->map(fn($file) => [
                'url' => Str::finish($pull_zone_url, '/') . $file['path'],
                'path' => Str::finish(self::MODS_PREFIX, '/') . $file['path'],
                'sha256_hash' => Str::lower($file['extra_metadata']['checksum']),
            ])->values()->toArray();
    }
}
