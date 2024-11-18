<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function setQuery()
    {
        return $this->model->newQuery();
    }

    public function all(array $columns = ['*'], array $relations = [])
    {
        return $this->model->select($columns)->with($relations)->get();
    }

    public function getAllWithOrdering(array $columns = ['id', 'name'], string $orderBy = 'name', string $direction = 'asc')
    {
        $query =  $this->model->select($columns)->orderBy($orderBy, $direction);
        return $query;
    }

    public function find($id, array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->find($id, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->model->find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    public function search($query, $columns = ['*'], $value)
    {
        return $query->when($value, function ($q, string $value) use ($columns) {
            $q->whereAny($columns, 'ILIKE', "%$value%");
        });
    }

    public function where(string $column, string $value, $operator = '=', bool $isFirst = false, $sortDirect = 'desc')
    {
        $query  = $this->model->where($column, $operator, $value);
        return $isFirst ? $query->orderBy('created_at', $sortDirect)->first() : $query->get();
    }

    public function paginate($query, $perPage = 10)
    {
        $query = $query->paginate($perPage);
        return $query;
    }

    public function paginateRows($filters, $perPage = 10)
    {
        return;
    }

    public function findMultipleIds(array $uuids, $relations = [], $returnQuery = false)
    {
        return $returnQuery ? $this->model->with($relations)->whereIn('id', $uuids) : $this->model->with($relations)->whereIn('id', $uuids)->get();
    }

    public function whereIn(string $column, array $value)
    {
        return $this->model->whereIn($column, $value);
    }
}
