<?php

namespace FilmAPI\Model;

use Exception;
use FilmAPI\Database;

/**
 * Base model from which other models will be extended.
 *
 * @package FilmApi
 */
class BaseModel
{
    /**
     * @var array $fields Entity fields.
     */
    protected array $fields = [];

    /**
     * Constructor
     */
    public function __construct(array $fields = array())
    {
        foreach ($fields as $field => $value) {
            $this->{$field} = $value;
        }
    }

    /**
     * Return associative object field values.
     */
    public function toArray(): array
    {
        return array_combine(
            $this->fields,
            array_map(function ($field) {
                return $this->{$field};
            }, $this->fields)
        );
    }
}
