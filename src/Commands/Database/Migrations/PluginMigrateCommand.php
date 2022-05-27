<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Ifui\LaravelPlugin\Commands\Database\Traits\PluginMigrateCommandTraits;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\MigrateCommand;

class PluginMigrateCommand extends MigrateCommand
{
    use PluginMigrateCommandTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:migrate {--database= : The database connection to use}
                {--force : Force the operation to run when in production}
                {--path=* : The path(s) to the migrations files to be executed}
                {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
                {--schema-path= : The path to a schema dump file}
                {--pretend : Dump the SQL queries that would be run}
                {--seed : Indicates if the seed task should be re-run}
                {--seeder= : The class name of the root seeder}
                {--step : Force the migrations to be run so they can be rolled back individually}';

    /**
     * Create a new migration command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $app = app();
        parent::__construct($app['migrator'], $app[Dispatcher::class]);
    }
}
