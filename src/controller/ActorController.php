<?php

namespace FilmAPI\Controller;

use Exception;
use FilmAPI\Exception\JsonValidatorException;
use FilmAPI\Model\ActorModel;
use FilmAPI\Repository\ActorRepository;
use FilmAPI\Validators\CreateActorValidator;
use FilmAPI\Validators\UpdateActorValidator;

/**
 * Actor controller will handle all film requests.
 *
 * @package FilmApi
 */
class ActorController extends BaseController
{
    public function list()
    {
        $repository = new ActorRepository();
        try {
            $films = $repository->list();
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $films]);
    }

    public function create()
    {
        $validator = new CreateActorValidator();
        try {
            $data = $validator->validate();
        } catch (JsonValidatorException $e) {
            $this->withJson(['msg' => $e->getMessage()], 400);
        }

        $film = new ActorModel($data);
        $repository = new ActorRepository();
        try {
            $film = $repository->store($film);
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $film->toArray()], 201);
    }

    public function update($id)
    {
        $repository = new ActorRepository();
        try {
            $exists = $repository->find((int) $id);
            if (!$exists) {
                $this->withJson(['msg' => 'Not found!'], 404);
            }
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $validator = new UpdateActorValidator();
        try {
            $data = $validator->validate();
        } catch (JsonValidatorException $e) {
            $this->withJson(['msg' => $e->getMessage()], 400);
        }

        $film = new ActorModel(array_merge($exists, $data));
        try {
            $film = $repository->store($film);
        } catch (Exception $e) {
            $this->withJson(['msg' => $e->getMessage()], 500);
        }

        $this->withJson(['data' => $film->toArray()]);
    }

    public function delete($id)
    {
        $repository = new ActorRepository();
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
