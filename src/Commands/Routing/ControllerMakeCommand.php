<?php

namespace Ifui\LaravelPlugin\Commands\Routing;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Routing\Console\ControllerMakeCommand as BaseControllerMakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:make-controller')]
class ControllerMakeCommand extends BaseControllerMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin controller class';

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        $path = $this->laravel->basePath(
            '/vendor/laravel/framework/src/illuminate/Routing/Console'
        );

        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : $path . $stub;
    }

    /**
     * Build the replacements for a parent controller.
     *
     * @return array
     */
    protected function buildParentReplacements(): array
    {
        $parentModelClass = $this->parseModel($this->option('parent'));
        $plugin = $this->argument('plugin');

        if (
            !class_exists($parentModelClass) &&
            $this->confirm(
                "A {$parentModelClass} model does not exist. Do you want to generate it?",
                true
            )
        ) {
            $this->call('plugin:make-model', ['name' => $parentModelClass, 'plugin' => $plugin]);
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            '{{ namespacedParentModel }}' => $parentModelClass,
            '{{namespacedParentModel}}' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            '{{ parentModel }}' => class_basename($parentModelClass),
            '{{parentModel}}' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
            '{{ parentModelVariable }}' => lcfirst(class_basename($parentModelClass)),
            '{{parentModelVariable}}' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values.
     *
     * @param array $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->parseModel($this->option('model'));
        $plugin = $this->argument('plugin');

        if (
            !class_exists($modelClass) &&
            $this->confirm(
                "A {$modelClass} model does not exist. Do you want to generate it?",
                true
            )
        ) {
            $this->call('plugin:make-model', ['name' => $modelClass, 'plugin' => $plugin]);
        }

        $replace = $this->buildFormRequestReplacements($replace, $modelClass);

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Build the model replacement values.
     *
     * @param array $replace
     * @param string $modelClass
     * @return array
     */
    protected function buildFormRequestReplacements(array $replace, $modelClass): array
    {
        [$namespace, $storeRequestClass, $updateRequestClass] = [
            'Illuminate\\Http',
            'Request',
            'Request',
        ];

        if ($this->option('requests')) {
            $namespace = 'App\\Http\\Requests';

            [$storeRequestClass, $updateRequestClass] = $this->generateFormRequests(
                $modelClass,
                $storeRequestClass,
                $updateRequestClass
            );
        }

        $namespacedRequests = $namespace . '\\' . $storeRequestClass . ';';

        if ($storeRequestClass !== $updateRequestClass) {
            $namespacedRequests .= PHP_EOL . 'use ' . $namespace . '\\' . $updateRequestClass . ';';
        }

        return array_merge($replace, [
            '{{ storeRequest }}' => $storeRequestClass,
            '{{storeRequest}}' => $storeRequestClass,
            '{{ updateRequest }}' => $updateRequestClass,
            '{{updateRequest}}' => $updateRequestClass,
            '{{ namespacedStoreRequest }}' => $namespace . '\\' . $storeRequestClass,
            '{{namespacedStoreRequest}}' => $namespace . '\\' . $storeRequestClass,
            '{{ namespacedUpdateRequest }}' => $namespace . '\\' . $updateRequestClass,
            '{{namespacedUpdateRequest}}' => $namespace . '\\' . $updateRequestClass,
            '{{ namespacedRequests }}' => $namespacedRequests,
            '{{namespacedRequests}}' => $namespacedRequests,
        ]);
    }

    /**
     * Generate the form requests for the given model and classes.
     *
     * @param string $modelClass
     * @param string $storeRequestClass
     * @param string $updateRequestClass
     * @return array
     */
    protected function generateFormRequests(
        $modelClass,
        $storeRequestClass,
        $updateRequestClass
    ): array {
        $storeRequestClass = 'Store' . class_basename($modelClass) . 'Request';
        $plugin = $this->argument('plugin');

        $this->call('plugin:make-request', [
            'name' => $storeRequestClass,
            'plugin' => $plugin,
        ]);

        $updateRequestClass = 'Update' . class_basename($modelClass) . 'Request';

        $this->call('plugin:make-request', [
            'name' => $updateRequestClass,
            'plugin' => $plugin,
        ]);

        return [$storeRequestClass, $updateRequestClass];
    }
}
