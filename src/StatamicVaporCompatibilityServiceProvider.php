<?php

namespace StatamicVaporCompatibility;

use Illuminate\Contracts\Http\Kernel;
use StatamicVaporCompatibility\Commands\CheckDockerfileContent;
use StatamicVaporCompatibility\Http\Middleware\StatamicVaporCheckIfTempFilesExist;
use StatamicVaporCompatibility\Listeners\StatamicVaporFileModificationSubscriber;
use StatamicVaporCompatibility\Tools\TemporaryStorage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use function base_path;
use function config;

class StatamicVaporCompatibilityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/statamic-vapor-compatibility.php', 'statamic-vapor-compatibility');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/statamic-vapor-compatibility.php' => config_path('statamic-vapor-compatibility.php'),
            ], 'statamic-vapor-compatibility-config');

            $this->commands([
                CheckDockerfileContent::class
            ]);
        }

        Event::subscribe(config('statamic-vapor-compatibility.event_subscriber', StatamicVaporFileModificationSubscriber::class));

        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(StatamicVaporCheckIfTempFilesExist::class);

        // Add tempDirectory disk
        $this->addTemporaryDiskToConfig();

        // Set custom paths to make Statamic Lambda compatible
        $this->overrideStatamicPaths();
    }

    protected function addTemporaryDiskToConfig()
    {
        config([
            'filesystems.disks.tempDirectory' => [
                'driver' => 'local',
                'root' => '/tmp',
            ]
        ]);
    }

    protected function overrideStatamicPaths()
    {
        config([
            'statamic.assets.image_manipulation.cache_path' => TemporaryStorage::public_path('img'),

            'statamic.forms.forms' => TemporaryStorage::resource_path('forms'),
            'statamic.forms.submissions' => TemporaryStorage::storage_path('forms'),

            'statamic.git.paths' => [
                TemporaryStorage::base_path('content'),
                TemporaryStorage::base_path('users'),
                TemporaryStorage::resource_path('blueprints'),
                TemporaryStorage::resource_path('fieldsets'),
                TemporaryStorage::resource_path('forms'),
                TemporaryStorage::resource_path('users'),
                TemporaryStorage::storage_path('forms'),
            ],

            'statamic.revisions.path' => TemporaryStorage::storage_path('statamic/revisions'),

            'statamic.search.drivers.local.path' => TemporaryStorage::storage_path('statamic/search'),

            'statamic.stache.stores.taxonomies.directory' => TemporaryStorage::base_path('content/taxonomies'),
            'statamic.stache.stores.terms.directory' => TemporaryStorage::base_path('content/taxonomies'),
            'statamic.stache.stores.collections.directory' => TemporaryStorage::base_path('content/collections'),
            'statamic.stache.stores.entries.directory' => TemporaryStorage::base_path('content/collections'),
            'statamic.stache.stores.navigation.directory' => TemporaryStorage::base_path('content/navigation'),
            'statamic.stache.stores.collection-trees.directory' => TemporaryStorage::base_path('content/trees/collections'),
            'statamic.stache.stores.nav-trees.directory' => TemporaryStorage::base_path('content/trees/navigation'),
            'statamic.stache.stores.globals.directory' => TemporaryStorage::base_path('content/globals'),
            'statamic.stache.stores.asset-containers.directory' => TemporaryStorage::base_path('content/assets'),
            'statamic.stache.stores.users.directory' => TemporaryStorage::base_path('users'),

            'statamic.static_caching.strategies.full.path' => TemporaryStorage::public_path('static'),

            'statamic.system.addons_path' => base_path('addons'),

            'statamic.users.repositories.file.paths.users' => TemporaryStorage::base_path('users'),
            'statamic.users.repositories.file.paths.roles' => TemporaryStorage::resource_path('users/roles.yaml'),
            'statamic.users.repositories.file.paths.groups' => TemporaryStorage::resource_path('users/groups.yaml'),
        ]);
    }
}
