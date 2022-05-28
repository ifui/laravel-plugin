<?php

namespace Ifui\LaravelPlugin\Providers;

use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateFreshCommand;
use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateCommand;
use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateMakeCommand;
use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateRefreshCommand;
use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateResetCommand;
use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateRollbackCommand;
use Ifui\LaravelPlugin\Commands\Database\Migrations\PluginMigrateStatusCommand;
use Ifui\LaravelPlugin\Commands\Database\Seeds\SeederMakeCommand;
use Ifui\LaravelPlugin\Commands\Factories\FactoryMakeCommand;
use Ifui\LaravelPlugin\Commands\Foundation\ModelMakeCommand;
use Ifui\LaravelPlugin\Commands\Foundation\PolicyMakeCommand;
use Ifui\LaravelPlugin\Commands\Foundation\RequestMakeCommand;
use Ifui\LaravelPlugin\Commands\Foundation\TestMakeCommand;
use Ifui\LaravelPlugin\Commands\PluginListCommand;
use Ifui\LaravelPlugin\Commands\PluginNewCommand;
use Ifui\LaravelPlugin\Commands\PluginRescanCommand;
use Ifui\LaravelPlugin\Commands\Routing\ControllerMakeCommand;
use Ifui\LaravelPlugin\Commands\Routing\MiddlewareMakeCommand;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     * @var array
     */
    protected array $commands = [
        PluginNewCommand::class,
        ControllerMakeCommand::class,
        PluginListCommand::class,
        PluginRescanCommand::class,
        MiddlewareMakeCommand::class,
        PluginMigrateCommand::class,
        PluginMigrateMakeCommand::class,
        PluginMigrateFreshCommand::class,
        PluginMigrateRefreshCommand::class,
        PluginMigrateRollbackCommand::class,
        PluginMigrateResetCommand::class,
        PluginMigrateStatusCommand::class,
        ModelMakeCommand::class,
        FactoryMakeCommand::class,
        SeederMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        TestMakeCommand::class,
    ];

    public function register(): void
    {
        $this->commands($this->commands);
    }

    public function provides(): array
    {
        return $this->commands;
    }
}
