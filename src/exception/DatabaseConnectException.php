<?php

namespace FilmAPI\Exception;

use Exception;

/**
 * DB connection exception.
 *
 * @package FilmApi
 */
class DatabaseConnectException extends Exception
{
    public function __construct($message = "Cannot connect to database!", $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
