<?php

namespace Ifui\LaravelPlugin\Commands\Foundation;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;

#[AsCommand(name: 'plugin:make-model')]
class ModelMakeCommand extends BaseModelMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-model';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'plugin:make-model';

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory(): void
    {
        $factory = Str::studly($this->argument('name'));
        $plugin = Str::studly($this->argument('plugin'));

        $this->call('plugin:make-factory', [
            'name' => "{$factory}Factory",
            'plugin' => $plugin,
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration(): void
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));
        $plugin = Str::studly($this->argument('plugin'));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('plugin:make-migration', [
            'name' => "create_{$table}_table",
            'plugin' => $plugin,
            '--create' => $table,
        ]);
    }

    /**
     * Create a seeder file for the model.
     *
     * @return void
     */
    protected function createSeeder(): void
    {
        $seeder = Str::studly(class_basename($this->argument('name')));
        $plugin = Str::studly($this->argument('plugin'));

        $this->call('plugin:make-seeder', [
            'name' => "{$seeder}Seeder",
            'plugin' => $plugin,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController(): void
    {
        $controller = Str::studly(class_basename($this->argument('name')));
        $plugin = Str::studly($this->argument('plugin'));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call(
            'plugin:make-controller',
            array_filter([
                'name' => "{$controller}Controller",
                'plugin' => $plugin,
                '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
                '--api' => $this->option('api'),
                '--requests' => $this->option('requests') || $this->option('all'),
            ])
        );
    }

    /**
     * Create a policy file for the model.
     *
     * @return void
     */
    protected function createPolicy(): void
    {
        $policy = Str::studly(class_basename($this->argument('name')));
        $plugin = Str::studly($this->argument('plugin'));

        $this->call('plugin:make-policy', [
            'name' => "{$policy}Policy",
            'plugin' => $plugin,
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }
}
