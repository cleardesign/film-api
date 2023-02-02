<?php

namespace FilmAPI\Controller;

use FilmAPI\Response;

/**
 * Base controller from which other controllers will be extended.
 *
 * @package FilmApi
 */
class BaseController
{
    public function withJson($data, int $status = 200)
    {
        $response = new Response();
        $response->json($data, $status);
    }
}
