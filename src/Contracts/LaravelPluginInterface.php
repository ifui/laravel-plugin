<?php

namespace Ifui\LaravelPlugin\Contracts;

interface LaravelPluginInterface
{
    /**
     * Get path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): static;
}
