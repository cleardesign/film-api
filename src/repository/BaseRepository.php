<?php

namespace FilmAPI\Repository;

use Exception;
use FilmAPI\Database;
use FilmAPI\Model\BaseModel;

/**
 * Base repository.
 *
 * @package FilmApi
 */
class BaseRepository
{
    /**
     * @var string $table Table name.
     */
    protected string $table = '';

    /**
     * @var array $fillable Updatable fields.
     */
    protected array $fillable = [];

    /**
     * Get table
     *
     * @return string
     */
    protected function getTable(): string
    {
        return $this->table;
    }

    /**
     * Save/Update entity in db.
     */
    public function store(BaseModel $model): BaseModel
    {
        $db = Database::getInstance();

        $data = $model->toArray();
        if (method_exists($model, 'getId') && $model->getId() > 0) {
            // Update entry.
            $pairs = $paramValues = [];
            $types = '';
            foreach ($this->fillable as $field) {
                $pairs[] = $field . ' = ?';
                $types .= is_string($data[$field]) ? 's' : 'i';
                $paramValues[] = $data[$field];
            }

            array_unshift($paramValues, $types . 'i');
            $paramValues[] = $model->getId();

            $sql = "UPDATE {$this->getTable()} SET " . implode(', ', $pairs) . " WHERE id = ?";

            $db->exec($sql, $paramValues);
        } else {
            // Insert
            $placeholders = $paramValues = [];
            $types = '';
            foreach ($this->fillable as $field) {
                $placeholders[] = '?';
                $types .= is_string($data[$field]) ? 's' : 'i';
                $paramValues[] = $data[$field];
            }
            array_unshift($paramValues, $types);

            $sql = "INSERT INTO {$this->getTable()} (" . implode(', ', $this->fillable) .
                ") VALUES (" . implode(',', $placeholders) . ")";
            $db->exec($sql, $paramValues);

            if (method_exists($model, 'setId')) {
                $model->setId($db->lastInsertId());
            }
        }

        return $model;
    }

    /**
     * Delete entry from db.
     *
     * @param int $id Entity ID.
     *
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM {$this->getTable()} WHERE id = ?";
        $db->exec($sql, array('i', $id));
    }

    /**
     * Get items.
     */
    public function list(): array
    {
        $db = Database::getInstance();
        return $db->select("SELECT * FROM {$this->getTable()}");
    }

    /**
     * Get items by values.
     *
     * @param string $column Column.
     * @param array $values Values.
     *
     * @return array
     *
     * @throws Exception
     */
    public function whereIn(string $column, array $values): array
    {
        $db = Database::getInstance();
        return $db->select("SELECT * FROM {$this->getTable()} WHERE {$column} IN ('" . implode("','", $values) . "')");
    }

    /**
     * Find item by ID
     *
     * @param int $id Entity ID
     *
     * @throws Exception
     */
    public function find(int $id)
    {
        $db = Database::getInstance();
        $results = $db->select("SELECT * FROM {$this->getTable()} WHERE id = ?", array('i', $id));
        return (!empty($results)) ? $results[0] : null;
    }
}
