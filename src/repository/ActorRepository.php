<?php

namespace FilmAPI\Repository;

/**
 * Actor repository.
 *
 * @package FilmApi
 */
class ActorRepository extends BaseRepository
{
    /**
     * @var string $table Table name.
     */
    protected string $table = 'actors';

    /**
     * @var string[] $fillable Allowed fields.
     */
    protected array $fillable = ['name', 'surname', 'gender'];
}
