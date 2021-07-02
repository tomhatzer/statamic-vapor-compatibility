<?php

namespace StatamicVaporCompatibility\Http\Middleware;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use StatamicVaporCompatibility\Exceptions\InvalidFilesRepositorySettings;
use StatamicVaporCompatibility\Tools\TemporaryStorage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Statamic\Console\Processes\Process;
use StatamicVaporCompatibility\Traits\GitManageable;
use Throwable;
use function array_shift;
use function base_path;
use function config;
use function escapeshellarg;
use function explode;
use function file_get_contents;
use function str_replace;
use function strpos;
use function substr;
use function throw_unless;
use function trim;

class StatamicVaporCheckIfTempFilesExist
{
    use GitManageable;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($_ENV['LAMBDA_TASK_ROOT']) || app()->isLocal()) {
            return $next($request);
        }

        throw_unless(
            config('statamic-vapor-compatibility.files_repository_name')
                && config('statamic-vapor-compatibility.files_repository'),
            InvalidFilesRepositorySettings::class,
            'Please set STATAMIC_FILES_REPOSITORY and STATAMIC_FILES_REPOSITORY_NAME variables in your .env file for this stage.'
        );

        $temporaryStorage = Storage::disk(TemporaryStorage::TEMP_DISK_NAME);

        if(! $temporaryStorage->exists(config('statamic-vapor-compatibility.files_repository_name'))) {
            $this->gitClone();
        }

        if(
            $request->is(config('statamic.cp.route'))
                || $request->is(config('statamic.cp.route') . '/*')
        ) {
            // Force update on every page load of control panel
            $this->gitPull();
        } else {
            // Update only if new version exists
            $this->updateToNewVersion();
        }


        foreach(config('statamic-vapor-compatibility.symlinks') as $src => $dest) {
            if(! $temporaryStorage->exists($dest)) {
                $temporaryStorage->makeDirectory($dest);
            }
        }

        return $next($request);
    }
}
