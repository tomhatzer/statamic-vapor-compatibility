<?php


namespace StatamicVaporCompatibility\Traits;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use StatamicVaporCompatibility\Exceptions\InvalidFilesRepositorySettings;
use StatamicVaporCompatibility\Tools\TemporaryStorage;
use Illuminate\Support\Facades\Storage;
use Statamic\Console\Processes\Process;
use function config;
use function count;
use function escapeshellarg;
use function explode;
use function throw_unless;
use function trim;
use const PHP_EOL;

trait GitManageable
{
    protected function gitConfig()
    {
        $this->configIsValid();

        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path('' . config('statamic-vapor-compatibility.files_repository_name')));
        $process->run(
            trim('git config user.name ' . escapeshellarg(config('statamic-vapor-compatibility.git.user_name')))
        );
        $process->run(
            trim('git config user.email ' . escapeshellarg(config('statamic-vapor-compatibility.git.user_email')))
        );
        $process->run('git config pull.rebase false');
    }

    protected function gitCommit(string $commitMessage = '')
    {
        $this->configIsValid();

        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path('' . config('statamic-vapor-compatibility.files_repository_name')));
        $process->run(
            trim('git commit -m ' . escapeshellarg($commitMessage))
        );
    }

    protected function gitAdd(string $filePath)
    {
        $this->configIsValid();

        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path('' . config('statamic-vapor-compatibility.files_repository_name')));
        $process->run('git add ' . escapeshellarg($filePath));
    }

    protected function gitPush()
    {
        $this->configIsValid();

        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path('' . config('statamic-vapor-compatibility.files_repository_name')));
        $process->run('git push');

        Cache::put('statamic-vapor-local-git-hash', $this->gitLocalHash());
    }
    protected function gitClone()
    {
        // Clone and update repository
        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path(''));
        $process->run(
            trim('git clone ' . escapeshellarg(config('statamic-vapor-compatibility.files_repository')) . ' ' . escapeshellarg(config('statamic-vapor-compatibility.files_repository_name')))
        );

        if(!Cache::has('statamic-vapor-local-git-hash')) {
            Cache::put('statamic-vapor-local-git-hash', $this->gitLocalHash());
        }
    }

    protected function gitPull()
    {
        // Upate repository
        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path(config('statamic-vapor-compatibility.files_repository_name')));
        $process->run('git pull');
    }

    protected function gitLocalHash(): string
    {
        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path(config('statamic-vapor-compatibility.files_repository_name')));
        $hash = $process->run('git rev-parse --verify HEAD');

        return trim($hash);
    }

    protected function gitRemoteHash(): ?string
    {
        $process = Process::create(Storage::disk(TemporaryStorage::TEMP_DISK_NAME)->path(config('statamic-vapor-compatibility.files_repository_name')));
        $hashes = $process->run('git ls-remote . HEAD');

        $lines = explode(PHP_EOL, $hashes);

        if(count($lines) > 1) {
            foreach($lines as $line) {
                if(Str::lower(Str::afterLast($line, ' ')) === 'head') {
                    return Str::before($line, ' ');
                }
            }

            return null;
        }

        return Str::before($lines[0], ' ');
    }

    protected function updateToNewVersion()
    {
        if(!Cache::has('statamic-vapor-local-git-hash')) {
            return;
        }

        $localHash = $this->gitLocalHash();

        if(!$localHash) {
            return;
        }

        if(Cache::get('statamic-vapor-local-git-hash') !== $localHash) {
            $this->gitPull();
        }
    }

    protected function configIsValid()
    {
        throw_unless(
            config('statamic-vapor-compatibility.files_repository_name') && config('statamic-vapor-compatibility.files_repository'),
            InvalidFilesRepositorySettings::class,
            'Please set STATAMIC_FILES_REPOSITORY and STATAMIC_FILES_REPOSITORY_NAME variables in your .env file for this stage.'
        );
    }

    protected function commitAsAdded($event, string $path)
    {
        $this->gitConfig();
        $this->gitAdd($path);
        $this->gitCommit($event->commitMessage());
        $this->gitPush();
    }

    protected function commitAsDeleted($event)
    {
        $this->gitConfig();
        $this->gitCommit($event->commitMessage());
        $this->gitPush();
    }
}
