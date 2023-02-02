<?php

namespace FilmAPI;

/**
 * Response class called by controllers
 *
 * @package FilmApi
 */
class Response
{
    /**
     * @const  STATUS_MESSAGES array HTTP Status message.
     */
    private const STATUS_MESSAGES = array(
        200 => 'OK',
        201 => 'Created',
        400 => 'Bad Request',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    );

    /**
     * Output JSON response
     *
     * @param mixed $data Data to output.
     * @param int $code Http code.
     */
    public function json(mixed $data = array(), int $code = 200): void
    {
        if (!array_key_exists($code, self::STATUS_MESSAGES)) {
            $code = 500;
        }
        header("HTTP/1.1 {$code} " . self::STATUS_MESSAGES[$code]);
        header("Content-Type:application/json");

        echo json_encode($data);
        exit;
    }
}
