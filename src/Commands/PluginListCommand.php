<?php

namespace Ifui\LaravelPlugin\Commands;

use Ifui\LaravelPlugin\Generators\FolderGenerator;
use Ifui\LaravelPlugin\Generators\StubGenerator;
use Ifui\LaravelPlugin\Utils\PluginJson;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:list')]
class PluginListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show plugins list table from plugin.json';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $pluginJson = new PluginJson($this->laravel['files']);

        $dataSource = $pluginJson->get();

        $allowKeys = ['name', 'author', 'email', 'version', 'description', 'active'];

        $pluginsData = [];
        foreach ($dataSource as $value) {
            $pluginsData[] = Collection::make($value)
                ->only($allowKeys)
                ->toArray();
        }

        $this->table($allowKeys, $pluginsData);
        return 0;
    }
}
