<?php

namespace Ifui\LaravelPlugin\Commands\Database\Seeds;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Database\Console\Seeds\SeederMakeCommand as BaseSeederMakeCommand;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:make-seeder')]
class SeederMakeCommand extends BaseSeederMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-seeder';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'plugin:make-seeder';

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace(): string
    {
        $seedNamespace = str_replace(
            '/',
            '\\',
            Config::get('laravel-plugin.paths.generator.seeder')
        );

        return plugin_namespace($this->argument('plugin'), $seedNamespace);
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        return str_replace('\\', '/', $name) . '.php';
    }
}
