<?php

namespace App\DTO;

class SearchPublishingHouseCriteria
{
    public ?string $name = '';

    public ?string $country = '';

    public ?string $orderBy = 'id';

    public ?string $direction = 'DESC';
}
