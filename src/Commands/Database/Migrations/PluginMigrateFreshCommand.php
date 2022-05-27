<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Illuminate\Database\Console\Migrations\FreshCommand;

class PluginMigrateFreshCommand extends FreshCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-fresh';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        parent::handle();

        $database = $this->input->getOption('database');

        $this->call(
            'plugin:migrate',
            array_filter([
                '--database' => $database,
                '--path' => $this->input->getOption('path'),
                '--realpath' => $this->input->getOption('realpath'),
                '--schema-path' => $this->input->getOption('schema-path'),
                '--force' => true,
                '--step' => $this->option('step'),
            ])
        );

        return 0;
    }
}
