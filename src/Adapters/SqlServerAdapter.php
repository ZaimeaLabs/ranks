<?php

declare(strict_types=1);

namespace Zaimea\Ranks\Adapters;

class SqlServerAdapter extends AbstractAdapter
{
    /**
     * Define the cumulative time format for Sql Server.
     *
     * @param  string  $column
     * @return string
     */
    public function rankTime(string $column): string
    {
        return "DATEDIFF(second,0,{$column})";
    }
}
