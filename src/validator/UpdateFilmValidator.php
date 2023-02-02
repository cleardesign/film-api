<?php

namespace FilmAPI\Validators;

/**
 * Update film validator.
 *
 * @package FilmApi
 */
class UpdateFilmValidator extends BaseValidator
{
    /**
     * @var string[] $fillable Allowed fields.
     */
    protected array $fillable = ['title', 'year', 'genre_id'];

    /**
     * @var array $rules Validation rules.
     */
    protected array $rules = [
        'title'    => 'min-length:2|max-length:200',
        'year'     => 'integer|min:1900|max:2023',
        'genre_id' => 'integer|exists:FilmAPI\\Repository\\GenreRepository',
    ];
}
