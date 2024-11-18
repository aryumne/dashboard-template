<?php

namespace App\Services;

use App\Repositories\BaseRepository;

abstract class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $columns = ['*'], array $relations = [])
    {
        return $this->repository->all($columns);
    }

    public function getById($id, array $columns = ['*'], array $relations = [])
    {
        return $this->repository->find($id, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function findWhere($column, $value, $operator = '=', bool $isFirst = false)
    {
        return $this->repository->where($column, $value, $operator, $isFirst);
    }

    public function paginate($perPage = 10, $columns = ['*'])
    {
        return $this->repository->paginate($perPage, $columns);
    }
}
