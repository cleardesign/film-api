<?php

namespace FilmAPI\Controller;

use Exception;
use FilmAPI\Repository\GenreRepository;

/**
 * Genre controller.
 *
 * @package FilmApi
 */
class GenreController extends BaseController
{
    public function list()
    {
        $repository = new GenreRepository();
        try {
            $genres = $repository->list();
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $genres]);
    }
}
