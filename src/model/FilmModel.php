<?php

namespace FilmAPI\Model;

/**
 * FilmModel model.
 *
 * @package FilmApi
 */
class FilmModel extends BaseModel
{
    /**
     * @var array $fields Entity fields.
     */
    protected array $fields = ['id', 'title', 'year', 'genre_id'];

    /**
     * @var ?int $id ID.
     */
    protected ?int $id = null;

    /**
     * @var ?string $title Title.
     */
    protected ?string $title;

    /**
     * @var ?int $year Year.
     */
    protected ?int $year;

    /**
     * @var ?int $genreId Genre ID.
     */
    protected ?int $genreId;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     */
    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return int|null
     */
    public function getGenreId(): ?int
    {
        return $this->genreId;
    }

    /**
     * @param int|null $genreId
     */
    public function setGenreId(?int $genreId): void
    {
        $this->genreId = $genreId;
    }
}
