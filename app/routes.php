<?php

/**
 * Routes file
 *
 * @package FilmApi
 */

use FilmAPI\Router;

$router = Router::getInstance();

$router->get('genre', ['FilmAPI\\Controller\\GenreController', 'list']);

$router->get('film', ['FilmAPI\\Controller\\FilmController', 'list']);
$router->post('film', ['FilmAPI\\Controller\\FilmController', 'create']);
$router->patch('film/{id}', ['FilmAPI\\Controller\\FilmController', 'update']);
$router->delete('film/{id}', ['FilmAPI\\Controller\\FilmController', 'delete']);

$router->get('actor', ['FilmAPI\\Controller\\ActorController', 'list']);
$router->post('actor', ['FilmAPI\\Controller\\ActorController', 'create']);
$router->patch('actor/{id}', ['FilmAPI\\Controller\\ActorController', 'update']);
$router->delete('actor/{id}', ['FilmAPI\\Controller\\ActorController', 'delete']);
