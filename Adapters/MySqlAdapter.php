<?php

declare(strict_types=1);

namespace ZaimeaLabs\Ranks\Adapters;

class MySqlAdapter extends AbstractAdapter
{
    /**
     * Define the rank time format for MySql.
     *
     * @param  string  $column
     * @return string
     */
    public function rankTime(string $column): string
    {
        return "TIME_TO_SEC({$column})";
    }
}
