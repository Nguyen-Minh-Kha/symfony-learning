<?php

namespace App\DTO;

// number of books in the user's cart to get the total price of the order
class NumberOfBooksInCart {
    public ?array $numberOfBooks = [];
    
    /**
    * initialize the number of books in the user's cart 
    */
    public function initialize(int $number)
    {
        array_push($this->numberOfBooks,$number);
    }
}

