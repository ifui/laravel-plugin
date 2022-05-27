<?php

namespace Ifui\LaravelPlugin\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Config;

class StubGenerator extends Generator
{
    /**
     * The replaces for stub names.
     *
     * @var array
     */
    protected array $replaces;

    /**
     * Generator the laravel-plugin.json file.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function generator(): void
    {
        $stubPaths = Config::get('laravel-plugin.paths.stub', []);

        foreach ($stubPaths as $key => $config) {
            $configTo = $this->path . $config['to'];
            $filepath = $this->replaceStub($configTo);

            $stubPath = __DIR__ . '/../../stubs/' . $config['from'];

            if (!$this->filesystem->isDirectory($dir = dirname($filepath))) {
                $this->filesystem->makeDirectory($dir, 0775, true);
            }

            $this->filesystem->put($filepath, $this->getStubContent($stubPath));
            $this->console->info("Created {$filepath}");
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @param string $stubPath
     * @return array|string
     * @throws FileNotFoundException
     */
    public function getStubContent(string $stubPath): array|string
    {
        $stub = $this->filesystem->get($stubPath);

        return $this->replaceStub($stub);
    }

    /**
     * Replace the Plugin Name for the given stub.
     *
     * @param string $stub
     * @return array|string
     */
    public function replaceStub(string &$stub): array|string
    {
        foreach ($this->replaces as $key => $value) {
            $stub = str_replace("{{ $key }}", $value, $stub);

            $stub = str_replace("{{$key}}", $value, $stub);
        }

        return $stub;
    }

    /**
     * Set replaces value.
     *
     * @param $replaces
     * @return StubGenerator
     */
    public function setReplaces($replaces): static
    {
        $this->replaces = $replaces;

        return $this;
    }
}
