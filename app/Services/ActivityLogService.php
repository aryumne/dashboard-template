<?php

namespace App\Services;

use App\Repositories\ActivityLogRepository;

class ActivityLogService extends BaseService
{
    protected $stageRepository;
    public function __construct(ActivityLogRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getRows($filters = [])
    {
        $perPage = $filters['entries'] ?? config('app.pagination');
        return $this->repository->paginateRows($filters, $perPage);
    }
}
