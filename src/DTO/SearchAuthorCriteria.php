<?php

namespace App\DTO;
/*
| Nom       | type    | valeur par défaut |
| --------- | ------- | ----------------- |
| name      | ?string | null              |
| orderBy   | ?string | 'id'              |
| direction | ?string | 'DESC'            |
*/

class SearchAuthorCriteria
{
    public ?string $name = null;

    public ?string $orderBy = 'id';

    public ?string $direction = 'DESC';
}
