<?php

namespace FilmAPI\Exception;

use Exception;

/**
 * JSON Validator Exception.
 *
 * @package FilmApi
 */
class JsonValidatorException extends Exception
{
    public function __construct($message = "Invalid request", $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
