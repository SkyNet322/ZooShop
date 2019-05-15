<?php


namespace App\Validators;

use App\Interfaces\IValidator;
use App\Errors\ValidationError;

class SubCategory implements IValidator
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function validate()
    {
        if ($this->value != '1') {
            throw new ValidationError('Button not valid');
        }
    }
}