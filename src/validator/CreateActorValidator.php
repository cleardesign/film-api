<?php

namespace FilmAPI\Validators;

/**
 * Create actor validator.
 *
 * @package FilmApi
 */
class CreateActorValidator extends BaseValidator
{
    /**
     * @var string[] $fillable Allowed fields.
     */
    protected array $fillable = ['name', 'surname', 'gender'];

    /**
     * @var array $rules Validation rules.
     */
    protected array $rules = [
        'name'    => 'required|min-length:2|max-length:40',
        'surname' => 'required|min-length:2|max-length:40',
        'gender'  => 'required|enum:male,female',
    ];
}
