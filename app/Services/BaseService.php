<?php

namespace App\Services;

use App\Contracts\BaseRepositoryInterface;

abstract class BaseService
{
    /**
     * @var BaseRepositoryInterface
     */
    protected $repository;

    /**
     * BaseService constructor.
     *
     * @param BaseRepositoryInterface $repository
     */
    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     *
     * @param array $columns
     * @return mixed
     */
    public function getAll($columns = ['*'])
    {
        return $this->repository->all($columns);
    }

    /**
     * Get paginated records
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function getPaginated($perPage = 15, $columns = ['*'])
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update a record
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Find a record by ID
     *
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function findById($id, $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Find a record by field
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->repository->findBy($field, $value, $columns);
    }

    /**
     * Find records by field
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = ['*'])
    {
        return $this->repository->findAllBy($field, $value, $columns);
    }

    /**
     * Find records by criteria
     *
     * @param array $criteria
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $criteria, $columns = ['*'])
    {
        return $this->repository->findWhere($criteria, $columns);
    }
}
