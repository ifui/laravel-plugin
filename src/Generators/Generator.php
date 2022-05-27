<?php

namespace Ifui\LaravelPlugin\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Console\Command as Console;

abstract class Generator
{
    /**
     * The plugin name.
     *
     * @var string
     */
    protected string $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $path;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem|null
     */
    protected Filesystem|null $filesystem;

    /**
     * The laravel console instance.
     *
     * @var Console|null
     */
    protected Console|null $console;

    /**
     * The construct.
     *
     * @param string $name
     * @param Filesystem|null $filesystem
     * @param Console|null $console
     */
    public function __construct(
        string $name,
        Filesystem $filesystem = null,
        Console $console = null
    ) {
        $this->name = $name;
        $this->path = Config::get('laravel-plugin.paths.plugin', 'plugins') . '/' . $name;
        $this->filesystem = $filesystem;
        $this->console = $console;
    }

    /**
     * Set fileSystem instance.
     *
     * @param Filesystem $filesystem
     * @return Generator
     */
    public function setFileSystem(Filesystem $filesystem): static
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Set console instance.
     *
     * @param Console $console
     * @return Generator
     */
    public function setConsole(Console $console): static
    {
        $this->console = $console;

        return $this;
    }
}
