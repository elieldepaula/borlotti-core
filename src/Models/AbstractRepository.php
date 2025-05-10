<?php

/**
 * Copyright (c) 2025 - Borlotti Project.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Eliel de Paula <elieldepaula@gmail.com>
 * @license     https://www.opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Borlotti\Core\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * Get a new query builder.
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get all records from a model.
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find one record from a model by id.
     * @return Illuminate\Database\Eloquent\Collection|Model|Model[]|null
     */
    public function find(int $id): array|Collection|Model|null
    {
        return $this->query()->find($id);
    }

    /**
     * Find a record by a field.
     * @param string $field
     * @param $value
     * @return Builder|null
     */
    public function findBy(string $field, $value): ?Builder
    {
        return $this->query()->where($field, $value);
    }

    /**
     * Create a new record.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing record.
     * @param int $id
     * @param array $data
     * @return bool|null
     */
    public function update(int $id, array $data): bool|null
    {
        $record = $this->find($id);
        return $record ? $record->update($data) : false;
    }

    /**
     * Remove a record by id.
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): bool|null
    {
        $record = $this->find($id);
        return $record ? $record->delete() : false;
    }

    /**
     * Search a record by column and value.
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function where(string $column, $value): Builder
    {
        return $this->query()->where($column, $value);
    }

    /**
     * Set multiple where conditions.
     * @param array $conditions
     * @return Builder
     */
    public function whereMultiple(array $conditions)
    {
        $query = $this->query();
        foreach ($conditions as $condition) {
            if (is_array($condition) && count($condition) === 3) {
                [$column, $operator, $value] = $condition;

                switch (strtolower($operator)) {
                    case 'in':
                        $query->whereIn($column, $value);
                        break;
                    case 'not in':
                        $query->whereNotIn($column, $value);
                        break;
                    case 'like':
                    case 'not like':
                        $query->where($column, $operator, $value);
                        break;
                    default:
                        $query->where($column, $operator, $value);
                }
            } elseif (is_array($condition)) {
                foreach ($condition as $column => $value) {
                    $query->where($column, '=', $value);
                }
            }
        }
        return $query;
    }

    /**
     * Ordering results.
     * @param string $column
     * @param string $direction
     * @return Model
     */
    public function orderBy(string $column, string $direction = 'asc')
    {
        return $this->query()->orderBy($column, $direction);
    }
}
