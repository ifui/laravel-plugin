<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Ifui\LaravelPlugin\Commands\Database\Traits\PluginMigrateCommandTraits;
use Illuminate\Database\Console\Migrations\RollbackCommand;

class PluginMigrateRollbackCommand extends RollbackCommand
{
    use PluginMigrateCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-rollback';

    /**
     * Create a new migration rollback command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $migrator = app()['migrator'];
        parent::__construct($migrator);
    }
}
