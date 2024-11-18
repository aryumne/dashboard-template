<?php

namespace App\Services;

use Throwable;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $ownRepository;
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
        $this->ownRepository = $repository;
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $row = $this->ownRepository->create([
                'name'          => $data['name'],
                'initial_name'  => strtoupper($data['initial_name']),
                'email'         => $data['email'],
                'is_active'     => $data['is_active'],
                'password'      => 'password',
                'join_date'     => $data['join_date'],
                'email_verified_at' => now(),
            ]);
            $row->syncRoles([$data['role']]);
            DB::commit();
            return $row;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    

    public function update($uuid, array $data)
    {
        return $this->ownRepository->update($uuid, [
            'name' => strtoupper($data['name']),
            'is_active' => $data['is_active'],
        ]);
    }

    public function getRows($filters = [])
    {
        $perPage = $filters['entries'] ?? config('app.pagination');
        return $this->ownRepository->paginateRows($filters, $perPage);
    }

    public function getAsOptions($roles = ['developer'], $isAllRoles = false)
    {
        $query = $this->ownRepository->getAllWithOrdering();
        return $isAllRoles === true ? $query->get() : $query->where('is_active', true)->role($roles)->get();
    }
}
