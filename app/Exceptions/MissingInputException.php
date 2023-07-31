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
}
