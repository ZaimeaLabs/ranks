<?php

declare(strict_types=1);

namespace Zaimea\Ranks\Adapters;

class PgsqlAdapter extends AbstractAdapter
{
    /**
     * Define the rank time format for Pgsql.
     *
     * @param  string  $column
     * @return string
     */
    public function rankTime(string $column): string
    {
        return "EXTRACT(EPOCH FROM {$column})";
    }
}
