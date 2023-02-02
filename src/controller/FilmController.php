<?php

namespace FilmAPI\Controller;

use Exception;
use FilmAPI\Exception\JsonValidatorException;
use FilmAPI\Model\FilmModel;
use FilmAPI\Repository\FilmRepository;
use FilmAPI\Validators\CreateFilmValidator;
use FilmAPI\Validators\UpdateFilmValidator;

/**
 * Film controller will handle all film requests.
 *
 * @package FilmApi
 */
class FilmController extends BaseController
{
    public function list()
    {
        $repository = new FilmRepository();
        try {
            $films = $repository->list();
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $films]);
    }

    public function create()
    {
        $validator = new CreateFilmValidator();
        try {
            $data = $validator->validate();
        } catch (JsonValidatorException $e) {
            $this->withJson(['msg' => $e->getMessage()], 400);
        }

        $film = new FilmModel($data);
        $repository = new FilmRepository();
        try {
            $film = $repository->store($film);
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $film->toArray()], 201);
    }

    public function update($id)
    {
        $repository = new FilmRepository();
        try {
            $exists = $repository->find((int) $id);
            if (!$exists) {
                $this->withJson(['msg' => 'Not found!'], 404);
            }
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $validator = new UpdateFilmValidator();
        try {
            $data = $validator->validate();
        } catch (JsonValidatorException $e) {
            $this->withJson(['msg' => $e->getMessage()], 400);
        }

        $film = new FilmModel(array_merge($exists, $data));
        try {
            $film = $repository->store($film);
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $film->toArray()]);
    }

    public function delete($id)
    {
        $repository = new FilmRepository();
        try {
            $exists = $repository->find((int) $id);
            if (!$exists) {
                $this->withJson(['msg' => 'Not found!'], 404);
            }
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $repository->delete((int) $id);

        $this->withJson(['msg' => 'Item deleted!']);
    }
}
