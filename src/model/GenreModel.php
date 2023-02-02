<?php

namespace FilmAPI\Model;

/**
 * Genre model.
 *
 * @package FilmApi
 */
class GenreModel extends BaseModel
{
    /**
     * @var array $fields Entity fields.
     */
    protected array $fields = ['id', 'name'];

    /**
     * @var ?int $id ID.
     */
    protected ?int $id = null;

    /**
     * @var ?string $name Name.
     */
    protected ?string $name;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
