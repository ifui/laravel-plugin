<?php

namespace Ifui\LaravelPlugin\Commands;

use Ifui\LaravelPlugin\Generators\FolderGenerator;
use Ifui\LaravelPlugin\Generators\StubGenerator;
use Ifui\LaravelPlugin\Utils\PluginJson;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:rescan')]
class PluginRescanCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:rescan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan all plugin and regenerate plugin.json';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        $pluginJson = new PluginJson($this->laravel['files']);
        $pluginJson->regenerator();

        $pluginScan = $pluginJson->scan();

        $allowKeys = ['name', 'author', 'email', 'version', 'description', 'active'];

        $pluginsData = [];
        foreach ($pluginScan as $value) {
            $pluginsData[] = Collection::make($value)
                ->only($allowKeys)
                ->toArray();
        }

        $this->table($allowKeys, $pluginsData);
        return 0;
    }
}
