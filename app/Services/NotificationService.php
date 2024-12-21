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

    public function show(int $id, int $userId): ?Notification
    {
        $notice = $this->repository->where('user_id', $userId)->find($id);
        if ($notice->isStatusSent()) {
            $notice->update(['status' => Notification::STATUS_READ]);
        }

        return $notice;
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = $this->repository->where('user_id', $request->user()->getKey());

        if ($status = $request->get('status')) {
            $query = $query->whereIn('status', $status);
        }
        if ($types = $request->get('types')) {
            $query = $query->whereIn('type', $types);
        }

        $notices = $query->orderBy('created_at', 'DESC')->paginate(10);

        return $notices;
    }
}
