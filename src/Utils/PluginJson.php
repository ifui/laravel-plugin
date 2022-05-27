<?php

namespace Ifui\LaravelPlugin\Utils;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class PluginJson
{
    /**
     * The laravel instance.
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * The plugin.json path.
     *
     * @var string
     */
    protected string $filepath;

    /**
     * The construct.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->filepath = Config::get('laravel-plugin.setup.config', base_path('plugin.json'));
    }

    /**
     * Determine if plugin config file exists.
     *
     * @return bool
     */
    public function exists(): bool
    {
        return $this->filesystem->exists($this->filepath);
    }

    /**
     * Delete the plugin config file.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return $this->filesystem->delete($this->filepath);
    }

    /**
     * Scan the plugins directories.
     *
     * @return Collection
     * @throws FileNotFoundException
     */
    public function scan(): Collection
    {
        $plugins = Collection::make();
        $directories = $this->filesystem->directories(Config::get('laravel-plugin.paths.plugin'));
        $laravelPluginJsonName = Config::get(
            'laravel-plugin.paths.stub.laravel-plugin.json.to',
            '/laravel-plugin.json'
        );

        foreach ($directories as $dir) {
            if ($this->filesystem->exists($dir . $laravelPluginJsonName)) {
                $fileContent = json_decode($this->filesystem->get($dir . $laravelPluginJsonName));

                $fileContent->active = $this->isActive($fileContent->name) ?? true;

                $plugins->push($fileContent);
            }
        }
        return $plugins;
    }

    /**
     * Return the file contents as array.
     *
     * @return Collection
     * @throws FileNotFoundException
     */
    public function get(): Collection
    {
        if ($this->exists()) {
            return Collection::make(json_decode($this->filesystem->get($this->filepath)));
        } else {
            return Collection::make([]);
        }
    }

    /**
     * Create a plugin.json to application.
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function regenerator(): bool
    {
        return $this->filesystem->put($this->filepath, $this->scan()->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Return the current plugin active status.
     *
     * @param string $name
     * @return bool
     * @throws FileNotFoundException
     */
    public function isActive(string $name): bool
    {
        $data = $this->get();
        // Default value will be true.
        return $data->where('name', $name)->first()->active ?? true;
    }
}
