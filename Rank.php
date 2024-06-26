<?php

declare(strict_types=1);

namespace ZaimeaLabs\Ranks;

use Error;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Rank
{
    /**
     * The start date of query.
     *
     * @var \Carbon\Carbon
     */
    public Carbon $start;

    /**
     * The end date of query.
     *
     * @var \Carbon\Carbon
     */
    public Carbon $end;

    /**
     * The select column of query.
     *
     * @var array
     */
    public array $selectColumn = [];

    /**
     * The date column of query.
     *
     * @var string
     */
    public string $dateColumn = 'created_at';

    /**
     * The rank alias of query.
     *
     * @var string
     */
    public ?string $rankAlias = null;

    /**
     * The sum alias of query.
     *
     * @var string
     */
    public ?string $sumAlias = null;

    public array $replace = ['TIME_TO_SEC', 'time', 'EXTRACT', 'DATEDIFF', 'second', 'EPOCH FROM ', '0', ',', '(', ')'];
    /**
     * Create a new query builder instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     */
    public function __construct(public Builder $builder)
    {
        //
    }

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query(Builder $builder): self
    {
        return new static($builder);
    }

    /**
     * Begin the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function model(string $model): self
    {
        return new static($model::query());
    }

    /**
     * Select columns for query.
     *
     * @param  array $columns
     * @return self
     */
    public function select(array $columns): self
    {
        $this->selectColumn = Arr::wrap($columns);

        return $this;
    }

    /**
     * Set query between dates.
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return self
     */
    public function between($start, $end): self
    {
        $this->start = $start;
        $this->end = $end;

        return $this;
    }

    /**
     * Set the date column name.
     *
     * @param  string  $column
     * @return self
     */
    public function dateColumn(string $column): self
    {
        $this->dateColumn = $column;

        return $this;
    }

    /**
     * Set the rank column alias.
     *
     * @param  string  $column
     * @return self
     */
    public function rankAlias(string $alias): self
    {
        $this->rankAlias = $alias;

        return $this;
    }

    /**
     * Set the sum column alias.
     *
     * @param  string  $column
     * @return self
     */
    public function sumAlias(string $alias): self
    {
        $this->sumAlias = $alias;

        return $this;
    }

    /**
     * Build rank result for query.
     *
     * @param  string  $column
     * @param  string  $rank
     * @return \Illuminate\Support\Collection
     */
    public function buildRank(string $column, string $rank): Collection
    {
        $values = $this->builder
            ->toBase()
            ->select($this->selectColumn)
            ->selectRaw("
                {$rank}({$column}) as {$this->getSumAlias($column)},
                RANK() OVER(ORDER BY {$this->getSumAlias($column)} DESC) as {$this->getRankAlias($column)}
            ")
            ->whereBetween(
                "{$this->builder->getModel()->getTable()}.$this->dateColumn",
                [$this->start, $this->end]
            )
            ->when($this->selectColumn, function ($query) {
                $query->groupBy($this->selectColumn);
            }, function() {
                throw new Error('
                    Is required select() function.
                    Rank::model(Model::class)
                        ->between(
                            start: Carbon $start,
                            end: Carbon $end
                        )
                        ->select(["column"])
                        ->rank("column")
                ');
            })
            ->get();

        return $values;
    }

    /**
     * Set rank to sum.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Collection
     */
    public function rank(string $column): Collection
    {
        return $this->buildRank($column, 'sum');
    }

    /**
     * Set rank to sum time.
     *
     * @param  string  $column
     * @return \Illuminate\Support\Collection
     */
    public function rankTime(string $column): Collection
    {
        return $this->buildRank(
            $this->getSqlAdapter()
            ->rankTime($column),
            'sum'
        );
    }

    /**
     * Get the rank alias for query.
     *
     * @param  string $column
     * @return string
     */
    protected function getRankAlias(string $column): string
    {
        $res = str_replace($this->replace, '', $column);

        return $this->rankAlias ?: $res.'_rank';
    }

    /**
     * Get the sum alias for query.
     *
     * @param  string $column
     * @return string
     */
    protected function getSumAlias(string $column): string
    {
        $res = str_replace($this->replace, '', $column);

        return $this->sumAlias ?: $res.'_sum';
    }

    /**
     * Get sql adapter.
     *
     * @return mixed
     */
    protected function getSqlAdapter(): mixed
    {
        $adapter = match ($this->builder->getConnection()->getDriverName()) {
            'mysql', 'mariadb' => new Adapters\MySqlAdapter(),
            'sqlite' => new Adapters\SqliteAdapter(),
            'pgsql' => new Adapters\PgsqlAdapter(),
            'sqlsrv' => new Adapters\SqlServerAdapter(),
            default => throw new Error('Unsupported database driver.'),
        };

        return $adapter;
    }
}
