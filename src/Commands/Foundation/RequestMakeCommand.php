<?php

namespace Ifui\LaravelPlugin\Commands\Foundation;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Foundation\Console\RequestMakeCommand as BaseRequestMakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:make-request')]
class RequestMakeCommand extends BaseRequestMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-request';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'plugin:make-request';
}
