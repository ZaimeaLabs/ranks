---
title: How to install package
description: How to install package
github: https://github.com/zaimealabs/ranks/edit/main/docs/
onThisArticle: true
sidebar: true
rightbar: true
---

# Ranks

[[TOC]]

## Working with

Support     | Function 
----------- | ----------------------
`MySql`     | `rank()`, `rankTime()`
`MariaDB`   | `rank()`, `rankTime()`
`Pgsql`     | `rank()`, `rankTime()` [NotTested]
`Sqlite`    | `rank()`, `rankTime()` [NotTested]
`SqlServer` | `rank()`, `rankTime()` [NotTested]

## Instalation

```json
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/zaimea/ranks"
        }
    ]
```

```bash
composer require zaimea/ranks
```
