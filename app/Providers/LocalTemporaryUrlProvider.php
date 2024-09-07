<?php

namespace App\Providers;

use GuzzleHttp\Psr7\MimeType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class LocalTemporaryUrlProvider extends ServiceProvider
{
    public function boot(): void
    {
        Storage::disk('local')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            $hash = now()->timestamp . hash_file('sha256', Storage::path($path));

            Cache::remember($hash, Carbon::make($expiration)->addMinutes(2), fn() => $path); // Extra time padding to prevent errors

            return URL::temporarySignedRoute(
                'temp.file',
                $expiration,
                array_merge($options, compact('hash'))
            );
        });

        Route::addRoute('GET', '_temp/{hash}', function (string $hash) {
            $path = Cache::get($hash);
            $filename = md5(now()->timestamp);
            $extension = File::extension($path);

            abort_unless($path, 419);
            abort_unless(Storage::exists($path), 500);

            if (request()->exists('once')) {
                Cache::delete($hash);
            }

            return response()->file(Storage::path($path), [
                'Content-Type' => MimeType::fromFilename($path),
                'Content-Disposition' => "attachment; filename=\"$filename.$extension\"",
            ]);
        })->name('temp.file');
    }
}
