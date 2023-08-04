<?php

namespace App\Exceptions;

use Exception;

class MissingInputException extends Exception
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = 422;

    protected $fields;

    private $validationError = 'Input Validation Failed!!';


    public function __construct(array $fields, $message = null)
    {
        $this->fields = $fields;
        $message = $message ?: "Your request is missing the following required input field(s)!";
        parent::__construct($message);
    }



    /**
     * Get the value of fields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the value of fields
     *
     * @return  self
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function renderMissingExceptionError()
    {
        return response()->json([
            'error' => $this->getValidationError(),
            'message' => $this->getMessage(),
            'fields' => $this->getFields()
        ], $this->status);
    }

    /**
     * Get the value of validationError
     */
    public function getValidationError()
    {
        return $this->validationError;
    }
}
