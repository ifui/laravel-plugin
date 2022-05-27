<?php

namespace Ifui\LaravelPlugin\Commands\Database\Migrations;

use Ifui\LaravelPlugin\Commands\Database\Traits\PluginMigrateCommandTraits;
use Illuminate\Database\Console\Migrations\StatusCommand;

class PluginMigrateStatusCommand extends StatusCommand
{
    use PluginMigrateCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-status';

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
