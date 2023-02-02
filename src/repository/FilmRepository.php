<?php

namespace FilmAPI\Repository;

/**
 * Film repository.
 *
 * @package FilmApi
 */
class FilmRepository extends BaseRepository
{
    /**
     * @var string $table Table name.
     */
    protected string $table = 'films';

    /**
     * @var string[] $fillable Allowed fields.
     */
    protected array $fillable = ['title', 'year', 'genre_id'];


    /**
     * Get items.
     */
    public function list(): array
    {
        $items = parent::list();

        $genreIds = array_filter(
            array_column($items, 'genre_id'),
            function ($genreId) {
                return !is_null($genreId);
            }
        );

        if ($genreIds) {
            $repository = new GenreRepository();
            $genres = $repository->whereIn('id', $genreIds);
            $genres = array_combine(
                array_column($genres, 'id'),
                $genres
            );

            foreach ($items as $key => $item) {
                if (empty($item['genre_id'])) {
                    continue;
                }
                $items[$key]['genre'] = $genres[$item['genre_id']];
            }
        }
        return $items;
    }
}
