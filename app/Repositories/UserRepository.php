<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected $filterColumns = [
        'users.name',
        'users.email',
    ];

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    private function applyFilters($filters)
    {
        $query = $this->setQuery();
        $query = $query
            ->select('users.*');
        // Searching
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query = $this->search($query, $this->filterColumns, $search);
        }
        return $query;
    }

    private function applySorting($query, array $filters)
    {
        $sortOrder = $filters['sort_order'] ?? 'desc';
        if (isset($filters['sort_key'])) {
            switch ($filters['sort_key']) {
                case "name":
                    return $query->orderBy('users.name', $sortOrder);
                case "email":
                    return $query->orderBy('users.email', $sortOrder);
                case "join_date":
                    return $query->orderBy('users.join_date', $sortOrder);
                default:
                    return $query->orderBy('users.created_at', $sortOrder);
            }
        } else {
            return $query->orderBy('users.created_at', $sortOrder);
        }
    }

    public function paginateRows($filters, $perPage = 10)
    {
        $query = $this->applyFilters($filters);
        $query = $this->applySorting($query, $filters);
        $query->groupBy('users.id');
        return $this->paginate($query, $perPage)->withQueryString();
    }
}
