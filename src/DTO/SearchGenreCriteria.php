<?php

namespace App\DTO;
/*
| Nom       | type    | valeur par défaut |
| --------- | ------- | ----------------- |
| title     | ?string | null              |
| orderBy   | ?string | 'id'              |
| direction | ?string | 'DESC'            |
*/

class SearchGenreCriteria
{
    public ?string $title = '';

    public ?string $orderBy = 'id';

    public ?string $direction = 'DESC';
}
