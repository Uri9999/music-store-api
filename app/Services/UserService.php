<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
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
        if ($roles = $request->get('roles')) {
            $query = $query->whereIn('role_id', $roles);
        }
        if ($status = $request->get('status')) {
            $query = $query->whereIn('status', $status);
        }
        if ($genders = $request->get('genders')) {
            $query = $query->whereIn('gender', $genders);
        }

        return $query->paginate(10);
    }

    public function lock($id): void
    {
        $this->repository->update(['status' => User::STATUS_LOCKED], $id);
    }

    public function unlock($id): void
    {
        $this->repository->update(['status' => User::STATUS_ACTIVE], $id);
    }

    public function show(int $id): ?User
    {
        $user = $this->repository->with([
            'media' => function ($query) {
                $query->where('collection_name', User::MEDIA_AVATAR);
            }
        ])->find($id);

        return $user;
    }

    public function update(int $id, Request $request): void
    {
        $user = $this->repository->find($id);
        $user = $this->repository->update($request->only(['name', 'gender', 'role_id', 'dob', 'status']), $id);
        if ($request->file('media_avatar')) {
            $user->clearMediaCollection(User::MEDIA_AVATAR);
            $user->addMediaFromRequest('media_avatar')->toMediaCollection(User::MEDIA_AVATAR);
        }
    }

}
