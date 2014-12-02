laravel4-namespace-migrator
===========================

Laravel 4 is not support namespaces in migration classes, but it is not a problem ;)

#Installation
1. Use Composer to install package into your project:

  ```bash
composer require "ed-fruty/laravel4-namespace-migrator":"dev-master@dev"
```
2. Add the service provider in `app/config/app.php`:

  ```bash
  'Fruty\LaravelNamespaceMigrator\LaravelNamespaceMigratorServiceProvider',
```
3. Publish package configuration
  
  ```bash
php artisan config:publish ed-fruty/laravel4-namespace-migrator
```



#Usage

<h2>Default migration namespaces searching</h2>
  When you call migrations like
```bash
php artisan migrate --path=app/Modules/Blog/Migrations
```
  Migrator automatically searches classes with namespace `App\Modules\Blog\Migrations` in `app/Modules/Blog/Migrations`
  To change default values, edit configuration file `app/config/packages/ed-fruty/laravel4-namespace-migrator/main.php` block `default`

 <h2>Reserving namespaces for migration paths</h2>
For reserving namespace for some path, edit configuration file `app/config/packages/ed-fruty/laravel4-namespace-migrator/main.php`. Example:

```php
'reserved' => [
      base_path('app/modules/Blog/migrations') => 'Blog\\Migrations\\',
  ]
```
 It means, when you call migrations like:
```bash
php artisan migrate --path=app/modules/Blog/migrations
```
Migrator automatically searches classes with namespace `Blog\Migrations` in that directory.

<h2>Workbenches</h2>
For workbench packages Migrator automatically searches migrations by `vendor/package` name.
When you call migrations like:

```bash
php artisan migrate --bench=foo/bar
```
Migrator searches classes with namespace `Foo\Bar\Migrations` in `workbench/foo/bar/src/migrations`
So if workbench namespace does not equal to `vendor/package` name you must register it in 'reserved' block like:
```php
base_path('workbench/foo/bar/src/migrations') => 'VendorNamespace\\PackageNamespace\\'
```  

<h2>Without namespaces</h2>
Migrator always searches classes with namespace firstly and if class not found with namespace it trying to search class without namespace. For example basic usage:

  ```
php artisan migrate
```

By default configs, Migrator firstly searches migration classes with namespace `App\database\migrations` in `app/database/migrations` and if it does not exists, Migrator tries to load class without namespace from that catalog.
