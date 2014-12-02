<?php
namespace Fruty\LaravelNamespaceMigrator;

use Illuminate\Support\ServiceProvider;
use Config;

class LaravelNamespaceMigratorServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('ed-fruty/namespace-migrator', 'ed-fruty/namespace-migrator', __DIR__);

        $this->app->bindShared(
            "migrator",
            function () {
                return new Migrator(
                    $this->app->make("migration.repository"),
                    $this->app->make("db"),
                    $this->app->make("files")
                );
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}