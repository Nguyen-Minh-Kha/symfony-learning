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

    /**
    * return the length of the array of books in the user's cart 
    */
    public function getLength()
    {
        if(is_countable($this->numberOfBooks)){
            return count($this->numberOfBooks);
        } else {
            return 0;
        }
    }

    /**
    * set the number with the given array 
    */
    public function setNumberOfBooks(array $numberOfBooks)
    {
        foreach($numberOfBooks as $number){
            $this->initialize($number);
        }
    }
}

