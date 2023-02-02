<?php

namespace FilmAPI\Validators;

/**
 * Update film validator.
 *
 * @package FilmApi
 */
class UpdateActorValidator extends BaseValidator
{
    /**
     * @var string[] $fillable Allowed fields.
     */
    protected array $fillable = ['name', 'surname', 'gender'];

    /**
     * @var array $rules Validation rules.
     */
    protected array $rules = [
        'name'    => 'min-length:2|max-length:40',
        'surname' => 'min-length:2|max-length:40',
        'gender'  => 'enum:male,female',
    ];
}
