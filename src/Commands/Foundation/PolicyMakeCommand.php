<?php

namespace Ifui\LaravelPlugin\Commands\Foundation;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Foundation\Console\PolicyMakeCommand as BasePolicyMakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:make-policy')]
class PolicyMakeCommand extends BasePolicyMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-policy';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'plugin:make-policy';
}
