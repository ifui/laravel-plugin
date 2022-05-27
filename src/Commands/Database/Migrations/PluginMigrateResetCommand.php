<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Ifui\LaravelPlugin\Commands\Database\Traits\PluginMigrateCommandTraits;
use Illuminate\Database\Console\Migrations\ResetCommand;

class PluginMigrateResetCommand extends ResetCommand
{
    use PluginMigrateCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-reset';

    /**
     * Create a new migration rollback command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(app()['migrator']);
    }
}
