<?php

namespace Ifui\LaravelPlugin\Commands;

use Ifui\LaravelPlugin\Generators\FolderGenerator;
use Ifui\LaravelPlugin\Generators\StubGenerator;
use Ifui\LaravelPlugin\Utils\PluginJson;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:new')]
class PluginNewCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        $name = $this->ask('Please input plugin name');
        $name = Str::studly($name);

        $author = $this->ask('Please input author name');
        $email = $this->ask('Please input email');
        $description = $this->ask('Please input description');
        $homepage = $this->ask('Please input homepage');

        // Define the providers for laravel-utopia.json
        $namespace = Config::get('laravel-plugin.namespace') . '\\' . $name;
        $namespaceComposer = Config::get('laravel-plugin.namespace') . '\\\\' . $name;
        $providers = ["{$namespace}\\App\\Providers\\AppServiceProvider"];

        $replaces = [
            'name' => $name,
            'author' => $author,
            'email' => $email,
            'description' => $description,
            'homepage' => $homepage,
            'providers' => json_encode($providers),
            'namespace' => $namespace,
            'namespaceComposer' => $namespaceComposer,
        ];

        // Generator folders
        with(new FolderGenerator($name))
            ->setFileSystem($this->laravel['files'])
            ->setConsole($this)
            ->generator();

        // Generator stubs
        with(new StubGenerator($name))
            ->setFileSystem($this->laravel['files'])
            ->setConsole($this)
            ->setReplaces($replaces)
            ->generator();

        // After create a new plugin will rescan the plugins folders and reset plugins.json.
        $pluginJson = new PluginJson($this->laravel['files']);
        $pluginJson->regenerator();

        $this->info("Plugin [{$name}] was created successfully.");

        return 0;
    }
}
