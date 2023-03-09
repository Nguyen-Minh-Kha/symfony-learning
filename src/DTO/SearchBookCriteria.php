<?php

namespace App\DTO;
/*
| nom        | type   | valeur par défaut |
| ---------- | ------ | ----------------- |
| title      | string | `''`              |
| authors    | array  | `[]`              |
| Genres     | array  | `[]`              |
| minPrice   | ?float | null              |
| maxPrice   | ?float | null              |

| nom              | type    | valeur par défaut |
| ---------------- | ------- | ----------------- |
| publishingHouses | ?array  | []                |
| orderBy          | ?string | 'title'           |
| direction        | ?string | 'ASC'             |
*/

class SearchBookCriteria
{
    public ?string $title = '';

    public ?array $authors = [];

    public ?array $genres = [];

    public ?float $minPrice = null;

    public ?float $maxPrice = null;

    public ?array $publishingHouses = [];

    public ?string $orderBy = 'title';

    public ?string $direction = 'ASC';

}
