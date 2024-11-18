<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use App\Http\Resources\OptionResource;
use App\Http\Resources\Admin\ActivityLogResource;

class ActivityLogController extends Controller
{
    protected $service, $userService;
    function __construct(ActivityLogService $service, UserService $userService)
    {
        $this->service = $service;
        $this->userService = $userService;
    }

    private function getEvents(): array
    {
        return [
            ['label' => 'Created', 'value' => 'created'],
            ['label' => 'Updated', 'value' => 'updated'],
            ['label' => 'Deleted', 'value' => 'deleted'],
        ];
    }

    private function getLogNames(): array
    {
        return [
            ['label' => 'Commerce', 'value' => 'Commerce'],
            ['label' => 'Pre Order', 'value' => 'Pre Order'],
            ['label' => 'BOM', 'value' => 'BOM'],
            ['label' => 'Project', 'value' => 'project'],
            ['label' => 'Purchase Order', 'value' => 'Purchase Order'],
            ['label' => 'Sample Request', 'value' => 'Sample Request'],
            ['label' => 'SR Destination', 'value' => 'SR Destination'],
            ['label' => 'Seasonal PO', 'value' => 'Seasonal PO'],
            ['label' => 'User', 'value' => 'user'],
        ];
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'entries', 'log_names', 'events', 'range_date', 'causer_id', 'sort_key', 'sort_order']);
        if (isset($filters['entries']) && $filters['entries'] > 100) $filters['entries'] = 100;
        $rows           = $this->service->getRows($filters);
        $formattedRows  = ActivityLogResource::collection($rows);
        $users          = $this->userService->getAsOptions([], true);
        $formattedUsers = OptionResource::collection($users);
        return Inertia::render('Admin/Activities/Index', [
            'rows'      => $formattedRows,
            'filters'   => $filters,
            'logNames'  => $this->getLogNames(),
            'events'    => $this->getEvents(),
            'users'     => $formattedUsers,
        ]);
    }
}
