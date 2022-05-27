<?php

namespace Ifui\LaravelPlugin\Utils;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

class LaravelPluginJson
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
        $this->filepath = Config::get('laravel-plugin.paths.plugin', base_path('plugins'));
    }

    /**
     * Determine if laravel-plugin.json file exists.
     *
     * @return bool
     */
    public function exists(): bool
    {
        return $this->filesystem->exists($this->filepath);
    }
}
