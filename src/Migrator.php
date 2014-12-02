<?php
namespace Fruty\LaravelNamespaceMigrator;

use Config;
use Illuminate\Database\Migrations\Migrator as LaravelMigrator;

/**
 * Class Migrator
 * @package Fruty\Laravel42NamespaceMigrator
 * @author Fruty <ed.fruty@gmail.com>
 */
class Migrator extends LaravelMigrator
{
    /**
     * Current path
     *
     * @var string
     */
    protected $path;

    /**
     * Run the outstanding migrations at a given path.
     *
     * @param  string  $path
     * @param  bool    $pretend
     * @return void
     */
    public function run($path, $pretend = false)
    {
        $this->path = $path;
        parent::run($path, $pretend);
    }

    /**
     * Resolve a migration instance from a file.
     *
     * @param  string  $file
     * @return object
     */
    public function resolve($file)
    {
        $file = implode("_", array_slice(explode("_", $file), 4));
        $class = studly_case($file);
        $classWithNamespace = $this->getNamespaceByPath() . studly_case($file);

        return class_exists($classWithNamespace) ? new $classWithNamespace() : new $class();
    }

    /**
     * Get migration class namespace by path
     *
     * @access protected
     * @return string
     */
    protected function getNamespaceByPath()
    {
        $reserved = Config::get('ed-fruty/namespace-migrator::main.reserved');

        // try to find registered namespace for the path
        foreach ($reserved as $path => $namespace) {
            if ($this->path == $path) {
                return $this->normalizeNamespace($namespace);
            }
        }

        // try to find workbench class migrations
        $basePath = base_path();
        if (preg_match("~^{$basePath}/workbench/(.+)/src/migrations~", $this->path, $matches)) {
            list($vendor, $package) = explode('/', $matches[1]);
            return $this->normalizeNamespace(studly_case($vendor)) . $this->normalizeNamespace(studly_case($package)) . "Migrations\\";
        }

        // return default application namespace
        $default = Config::get('ed-fruty/namespace-migrator::main.default');

        $fileSpace = str_replace($default['path'], $default['namespace'], $this->path);
        $namespace = str_replace(DIRECTORY_SEPARATOR, '\\', $fileSpace);
        return $this->normalizeNamespace($namespace);
    }

    /**
     * Normalize namespace
     *
     * @access public
     * @param string $namespace
     * @return string
     */
    protected function normalizeNamespace($namespace)
    {
        return rtrim($namespace, '\\'). '\\';
    }
}