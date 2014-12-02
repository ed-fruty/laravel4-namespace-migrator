<?php
return [
    /**
     * Reserved namespaces for migration pathes. Example:
     *
     * 'reserved' => [
     *      base_path('app/modules/Blog/migrations') => 'Blog\\Migrations\\',
     * ]
     *
     * It mean, when you call migrations like:
     *
     *  `php artisan migrate --path=app/modules/Blog/migrations`
     *
     * Migrator automatically search classes with namespace Blog\Migrations in that directory
     *
     * For workbench packages Migrator automatically search migrations by vendor/package name.
     * When you call migrations like:
     *
     *  `php artisan migrate --bench=foo/bar`
     *
     * Migrator search classes with namespace Foo\Bar\Migrations in workbench/foo/bar/src/migrations
     * So if workbench namespace doesn't equal to vendor/package name you must register it in 'reserved' block like:
     *
     *  base_path('workbench/foo/bar/src/migrations') => 'VendorNamespace\\PackageNamespace\\'
     */
    'reserved' => [

    ],


    /**
     * Default migration namespace search.
     * When you call migrations as
     * `php artisan migrate --path=app\Modules\Blog\Migrations`
     *
     * Migrator automatically search classes with namespace App\Modules\Blog\Migrations
     */
    'default' => [

        'path' => base_path('app/'),

        'namespace' => 'App\\',

    ]
];