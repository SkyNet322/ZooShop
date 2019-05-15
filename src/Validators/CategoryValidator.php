<?php


namespace App\Validators;

use App\Interfaces\IValidator;
use App\Errors\ValidationError;

class CategoryValidator implements IValidator
{
    public $CATEGORIES = ['animal', 'food', 'product'];

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function validate()
    {
        if (!in_array($this->value, $this->CATEGORIES)) {
            throw new ValidationError('Name not valid');
        }
    }
}
