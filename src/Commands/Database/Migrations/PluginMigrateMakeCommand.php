<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Ifui\LaravelPlugin\Commands\Database\Traits\PluginMigrateCommandTraits;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;

class PluginMigrateMakeCommand extends MigrateMakeCommand
{
    use PluginMigrateCommandTraits;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'plugin:make-migration {name : The name of the migration}
        {plugin : The name of the plugin}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration}';

    /**
     * Create a new migration install command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $app = app();
        parent::__construct($app['migration.creator'], $app['composer']);
    }
}
