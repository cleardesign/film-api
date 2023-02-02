<?php

namespace FilmAPI\Repository;

/**
 * Genre repository.
 *
 * @package FilmApi
 */
class GenreRepository extends BaseRepository
{
    /**
     * @var string $table Table name.
     */
    protected string $table = 'genres';

    /**
     * @var string[] $fillable Allowed fields.
     */
    protected array $fillable = ['name'];
}
