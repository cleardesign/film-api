<?php

namespace FilmAPI\Model;

/**
 * Actor model.
 *
 * @package FilmApi
 */
class ActorModel extends BaseModel
{
    /**
     * @var array $fields Entity fields.
     */
    protected array $fields = ['id', 'name', 'surname', 'gender'];

    /**
     * @var ?int $id ID.
     */
    protected ?int $id = null;

    /**
     * @var ?string $name Name.
     */
    protected ?string $name;

    /**
     * @var ?string $surname Surname.
     */
    protected ?string $surname;

    /**
     * @var ?string $gender Gender.
     */
    protected ?string $gender;


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

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }
}
