<?php

declare(strict_types=1);

namespace Zaimea\Ranks\Adapters;

abstract class AbstractAdapter
{
    /**
     * Define the rank Time format.
     *
     * @param  string  $column
     * @return string
     */
    abstract public function rankTime(string $column): string;
}
