<?php

namespace Ifui\LaravelPlugin;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class LaravelPlugin
{
    /**
     * The laravel application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $path;

    /**
     * The plugin config path.
     *
     * @var string
     */
    protected string $configPath;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * All plugins with load plugin.json.
     *
     * @var Collection
     */
    protected Collection $plugins;

    /**
     * The constructor.
     * @param Application $app
     * @param string $path
     * @throws FileNotFoundException
     */
    public function __construct(Application $app, string $path)
    {
        $this->path = $path;
        $this->app = $app;
        $this->filesystem = $app['files'];
        $this->configPath = $this->app['config']->get('laravel-plugin.setup.config');
        $this->plugins = Collection::make(json_decode($this->filesystem->get($this->configPath)));
    }

    /**
     * Get path.
     *
     * @param string|null $name
     * @return string
     */
    public function getPath(string $name = null): string
    {
        if ($name) {
            return $this->path . DIRECTORY_SEPARATOR . $name;
        }

        return $this->path;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get plugins.
     *
     * @throws FileNotFoundException
     */
    public function getPlugins(): Collection
    {
        return Collection::make(json_decode($this->filesystem->get($this->configPath)));
    }

    /**
     * Find the plugin for name.
     *
     * @param string $name
     * @return mixed
     */
    public function find(string $name): mixed
    {
        return $this->plugins->where('name', $name)->firstOrFail();
    }
}
