<?php

namespace App\Contracts;

interface BaseRepositoryInterface
{
    /**
     * Get all models.
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Get paginated models.
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']);

    /**
     * Create a new model.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a model.
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete a model.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find a model by id.
     *
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find a model by field.
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * Find models by field.
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = ['*']);

    /**
     * Find a model by multiple criteria.
     *
     * @param array $criteria
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $criteria, $columns = ['*']);
}
