<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository;
        if ($searchName = $request->get('search_name')) {
            $query = $query->fullTextSearch($searchName);
        }
        if ($roleId = $request->get('role_id')) {
            $query =$query->where('role_id', $roleId);
        }
        if ($status = $request->get('status')) {
            $query =$query->where('status', $status);
        }
        if ($gender = $request->get('gender')) {
            $query =$query->where('gender', $gender);
        }

        return $query->paginate(15);
    }

}
