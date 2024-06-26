<p align="center">
  <a href="https://zaimea.com/" target="_blank">
    <img src=".github/ranks.svg" alt="Ranks" width="300">
  </a>
</p>
<p align="center">
  Ranks for Models
<p>
<p align="center">
    <a href="https://github.com/zaimealabs/ranks/actions/workflows/ranks-tests.yml"><img src="https://github.com/zaimealabs/ranks/actions/workflows/ranks-tests.yml/badge.svg" alt="Ranks Tests"></a>
    <a href="https://github.com/zaimealabs/ranks/blob/main/LICENSE"><img src="https://img.shields.io/badge/License-Mit-brightgreen.svg" alt="License"></a>
</p>
<div align="center">
  Hey 👋 thanks for considering making a donation, with these donations I can continue working to contribute to ZaimeaLabs projects.
  
  [![Donate](https://img.shields.io/badge/Via_PayPal-blue)](https://www.paypal.com/donate/?hosted_button_id=V6YPST5PUAUKS)
</div>

Support     | Function 
----------- | ----------------------
`MySql`     | `rank()`, `rankTime()`
`MariaDB`   | `rank()`, `rankTime()`
`Pgsql`     | `rank()`, `rankTime()` [NotTested]
`Sqlite`    | `rank()`, `rankTime()` [NotTested]
`SqlServer` | `rank()`, `rankTime()` [NotTested]

## Usage

To generate a rank for your model, import the `ZaimeaLabs\Ranks\Rank` class and pass along a model or query.
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
