<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Models\Notification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationService implements NotificationServiceInterface
{
    protected NotificationRepositoryInterface $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $reqeust): LengthAwarePaginator
    {
        $query = $this->repository;
        if ($status = $reqeust->get('status')) {
            $query->where('status', $status);
        }
        if ($type = $reqeust->get('type')) {
            $query->where('type', $type);
        }
        $query->orderBy('created_at', 'desc');

        $notices = $query->paginate(10);

        return $notices;
    }

    public function store(array $attrs): Notification
    {
        $notice = $this->repository->create($attrs);

        NotificationCreated::dispatch($notice);

        return $notice;
    }

    public function updateToSent(Notification $notification)
    {
        $this->repository->update(['status' => Notification::STATUS_SENT, 'send_at' => Carbon::now()], $notification->getKey());
    }

    public function countNotReadYet(Request $request): int
    {
        return $this->repository->where('user_id', $request->user()->getKey())->count();
    }

    public function getMyNotify(Request $request): LengthAwarePaginator
    {
        $notices = $this->repository->where('user_id', $request->user()->getKey())
            ->orderByRaw("FIELD(status, 1, 2)")
            ->paginate(5);

        return $notices;
    }
}
