<?php

namespace Ifui\LaravelPlugin\Commands\Routing;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Routing\Console\MiddlewareMakeCommand as BaseMiddlewareMakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:make-middleware')]
class MiddlewareMakeCommand extends BaseMiddlewareMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-middleware';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'plugin:make-middleware';
}
