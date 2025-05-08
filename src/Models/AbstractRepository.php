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

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected Model $model;

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
        return $this->model->find($id);
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
     * @return Model
     */
    public function where(string $column, $value): Model
    {
        return $this->model->where($column, $value);
    }
}
