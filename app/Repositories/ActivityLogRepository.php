<?php

namespace App\Repositories;

use App\Models\ActivityLog;

class ActivityLogRepository extends BaseRepository
{
    protected $filterColumns = [
        'activity_log.description',
        'activity_log.log_name',
        'activity_log.event',
        'users.name',
    ];

    public function __construct(ActivityLog $model)
    {
        parent::__construct($model);
    }

    private function applyFilters($filters)
    {
        $query = $this->setQuery();
        $query = $query
            ->select('activity_log.*', 'users.name as causer_name')
            ->leftjoin('users', 'users.id', '=', 'activity_log.causer_id');
        // Searching
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query = $this->search($query, $this->filterColumns, $search);
        }

        if (isset($filters['log_names']) && $filters['log_names'] !== "all") {
            $query = $query->whereIn('activity_log.log_name', $filters['log_names']);
        }
        if (isset($filters['events']) && $filters['events'] !== "all") {
            $query = $query->whereIn('activity_log.event', $filters['events']);
        }
        if (isset($filters['causer_id']) && $filters['causer_id'] !== "all") {
            $query = $query->where('activity_log.causer_id', $filters['causer_id']);
        }
        if (isset($filters['range_date']) && $filters['range_date'] !== "") {
            $dates = explode(',', $filters['range_date']);
            $query = $query->whereBetween('activity_log.created_at', [$dates[0], $dates[1]]);
        }
        return $query;
    }

    private function applySorting($query, array $filters)
    {
        $sortOrder = $filters['sort_order'] ?? 'desc';
        if (isset($filters['sort_key'])) {
            switch ($filters['sort_key']) {
                case "log_name":
                    return $query->orderBy('activity_log.log_name', $sortOrder);
                case "event":
                    return $query->orderBy('activity_log.event', $sortOrder);
                case "causer_name":
                    return $query->orderBy('users.name', $sortOrder);
                default:
                    return $query->orderBy('activity_log.created_at', $sortOrder);
            }
        } else {
            return $query->orderBy('activity_log.created_at', $sortOrder);
        }
    }

    public function paginateRows($filters, $perPage = 10)
    {
        $query = $this->applyFilters($filters);
        $query = $this->applySorting($query, $filters);
        $query->groupBy(['activity_log.id', 'causer_name']);
        return $this->paginate($query, $perPage)->withQueryString();
    }
}
