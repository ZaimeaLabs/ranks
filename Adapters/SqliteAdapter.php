<?php

declare(strict_types=1);

namespace ZaimeaLabs\Ranks\Adapters;

use Error;

class SqliteAdapter extends AbstractAdapter
{
    /**
     * Define the rank time format for Sqlite.
     *
     * @param  string  $column
     * @return string
     */
    public function rankTime(string $column): string
    {
        return "time({$column})";
    }
}
