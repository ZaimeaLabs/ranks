---
title: How to use package
description: How to use package
github: https://github.com/zaimealabs/ranks/edit/main/docs/
onThisArticle: true
sidebar: true
rightbar: true
---

# Ranks Usage

[[TOC]]

## Usage

To generate a rank for your model, import the `Zaimea\Ranks\Rank` class and pass along a model or query.
`::model()` come as it is.
`::query()` allow you to use additional filter like `where()`.
`->select(['column'])` to group your result.

```php
    $model = Rank::model(Match::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->select(['user_id'])
        ->rank('scored');

    $query = Rank::query(Match::whereNotNull('user_id'))
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->select(['user_id'])
        ->rank('scored')

    $query = Rank::query(Match::where('type', 'csgo'))
        ->dateColumn('played_at')
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear())
        ->select(['user_id'])
        ->rankTime('duration');
```
## Select Column

To select columns just use `select(['name'])`
```php
->select(['name', 'csgo'])
```

## Date Column

If your column is not `created_at` just use `dateColumn('pointed_date_column')`
```php
->dateColumn('pointed_date_column')
```

## Rank Alias
You can set custom rank alias:
```php
->rankAlias('score_rank')
```

## Sum Alias
You can set custom sum alias:
```php
->sumAlias('score_sum')
```

### Ranks
***You can use the following ranks:***  
Function       | Parameter
-------------- | -----------
`->rank()`     | `'column'`
`->rankTime()` | `'column'`
