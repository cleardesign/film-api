<?php

namespace FilmAPI\Validators;

use FilmAPI\Exception\JsonValidatorException;

/**
 * Base Validator call from which all validators will be extended.
 *
 * @package FilmApi
 */
class BaseValidator
{
    /**
     * Validate JSON body request
     *
     * @return array Validated input fields.
     *
     * @throws JsonValidatorException
     */
    public function validate()
    {
        $inputJson = file_get_contents('php://input');
        $input = json_decode($inputJson, true);

        if (!is_array($input) || count(array_diff(array_keys($input), $this->fillable)) > 0) {
            throw new JsonValidatorException("Validation error! Invalid data sent!");
        }

        foreach ($this->rules as $field => $rulesString) {
            $rules = explode('|', $rulesString);
            foreach ($rules as $rule) {
                $parts = explode(':', $rule);

                switch ($parts[0]) {
                    case 'required':
                        if (!array_key_exists($field, $input)) {
                            throw new JsonValidatorException("Validation error! Field {$field} is missing!");
                        }
                        break;
                    case 'min-length':
                        if (array_key_exists($field, $input) && strlen($input[$field]) < $parts[1]) {
                            throw new JsonValidatorException("Validation error! Minimum length for {$field} is {$parts[1]}!");
                        }
                        break;
                    case 'max-length':
                        if (array_key_exists($field, $input) && strlen($input[$field]) > $parts[1]) {
                            throw new JsonValidatorException("Validation error! Maximum length for {$field} is {$parts[1]}!");
                        }
                        break;
                    case 'integer':
                        if (array_key_exists($field, $input) && !is_int($input[$field])) {
                            throw new JsonValidatorException("Validation error! Field {$field} should be integer!");
                        }
                        break;
                    case 'min':
                        if (array_key_exists($field, $input) && $input[$field] < $parts[1]) {
                            throw new JsonValidatorException("Validation error! Field {$field} should a minimum value of {$parts[1]}!");
                        }
                        break;
                    case 'max':
                        if (array_key_exists($field, $input) && $input[$field] > $parts[1]) {
                            throw new JsonValidatorException("Validation error! Field {$field} should a maximum value of {$parts[1]}!");
                        }
                        break;
                    case 'enum':
                        if (array_key_exists($field, $input) && !in_array($input[$field], explode(',', $parts[1]))) {
                            throw new JsonValidatorException("Validation error! Field {$field} should have one of values: {$parts[1]}!");
                        }
                        break;
                    case 'exists':
                        if (array_key_exists($field, $input)) {
                            $repository = new $parts[1]();
                            if (empty($repository->find((int) $input[$field]))) {
                                throw new JsonValidatorException("Validation error! Value {$input[$field]} is invalid for field {$field}!");
                            }
                        }
                        break;
                }
            }
        }

        return $input;
    }
}
