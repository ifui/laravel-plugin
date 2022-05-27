<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Ifui\LaravelPlugin\Commands\Database\Traits\PluginMigrateCommandTraits;
use Illuminate\Database\Console\Migrations\RefreshCommand;

class PluginMigrateRefreshCommand extends RefreshCommand
{
    use PluginMigrateCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-refresh';

    /**
     * Run the rollback command.
     *
     * @param string $database
     * @param string $path
     * @param int $step
     * @return void
     */
    protected function runRollback($database, $path, $step): void
    {
        $this->call(
            'plugin:migrate-rollback',
            array_filter([
                '--database' => $database,
                '--path' => $path,
                '--realpath' => $this->input->getOption('realpath'),
                '--step' => $step,
                '--force' => true,
            ])
        );
    }

    /**
     * Run the reset command.
     *
     * @param string $database
     * @param string $path
     * @return void
     */
    protected function runReset($database, $path): void
    {
        $this->call(
            'plugin:migrate-reset',
            array_filter([
                '--database' => $database,
                '--path' => $path,
                '--realpath' => $this->input->getOption('realpath'),
                '--force' => true,
            ])
        );
    }
}
