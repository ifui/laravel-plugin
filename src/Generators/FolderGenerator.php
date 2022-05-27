<?php

namespace Ifui\LaravelPlugin\Generators;

use Illuminate\Support\Facades\Config;

class FolderGenerator extends Generator
{
    /**
     * Generator Folders.
     *
     * @return void
     */
    public function generator(): void
    {
        $generators = Config::get('laravel-plugin.paths.generator', []);

        foreach ($generators as $key => $value) {
            $path = $this->path . '/' . $value;
            if ($this->filesystem->makeDirectory($path, 0755, true)) {
                $this->console->info("Created key: {$key} of generator config");
            } else {
                $this->console->error("Failed created key: {$key} of generator config");
            }
        }
    }
}
