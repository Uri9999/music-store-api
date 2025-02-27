<?php

namespace App\Services;

use App\Interfaces\OrderItemServiceInterface;
use App\Interfaces\TabServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Interfaces\UserSubscriptionServiceInterface;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TabService implements TabServiceInterface
{
    protected $tabRepository;

    public function __construct(TabRepositoryInterface $tabRepository)
    {
        $this->tabRepository = $tabRepository;
    }

    public function index(Request $request)
    {
        $query = $this->tabRepository->with([
            'user:id,name',
            'category:id,name',
            'media' => function ($q) {
                $q->where('collection_name', Tab::MEDIA_TAB_IMAGE);
            }
        ])->withCount(['orderItems as total_order_items']);
        if ($orderPrice = $request->get('orderPrice')) {
            $query = $query->orderBy('price', $orderPrice);
        }
        if ($orderCreatedAt = $request->get('orderCreatedAt')) {
            $query = $query->orderBy('price', $orderCreatedAt);
        }
        if ($search = $request->get('search')) {
            $query = $query->fullTextSearch($search);
        }
        if ($categories = $request->get('categories')) {
            $query = $query->whereIn('category_id', $categories);
        }
        if ($userId = $request->get('user_id')) {
            $query = $query->where('user_id', $userId);
        }

        return $query->orderBy('created_at', 'DESC')->paginate(8);
    }

    public function getNewTab(): Collection
    {
        return $this->tabRepository->with([
            'user:id,name',
            'media' => function ($q) {
                $q->where('collection_name', Tab::MEDIA_TAB_IMAGE);
            }
        ])->withCount(['orderItems as total_order_items'])->orderBy('created_at', 'DESC')->take(9)->get();
    }

    public function getRandomTab(): Collection
    {
        return $this->tabRepository->with([
            'user:id,name',
            'media' => function ($q) {
                $q->where('collection_name', Tab::MEDIA_TAB_IMAGE);
            }
        ])
        ->withCount(['orderItems as total_order_items'])
        ->orderByDesc('total_order_items')
        ->take(9)->get();

    }

    public function show($id)
    {
        return $this->tabRepository->with([
            'user:id,name',
            'category:id,name',
            'media' => function ($query) {
                $query->whereIn('collection_name', [Tab::MEDIA_TAB_IMAGE, Tab::MEDIA_TAB_PDF]);
            }
        ])->withCount(['orderItems as total_order_items'])->find($id);
    }

    public function showForUser(string $slug, Request $request): ?Tab
    {
        $collectFile = [Tab::MEDIA_TAB_IMAGE];
        $boughtStatus = false;
        $checkSubscription = false;
        /** @var OrderItemServiceInterface $orderItemSerice */
        $orderItemSerice = app(OrderItemServiceInterface::class);
        $user = $request->user();
        $tab = $this->tabRepository->where('slug', $slug)->firstOrFail();
        $tabId = $tab->getKey();
        $free = false;
        if ($tab->price <= $tab->discount_money) {
            $free = true;
        }
        if ($user) {
            $boughtStatus = $orderItemSerice->checkBoughtTab($tabId, $user->getKey());

            /** @var UserSubscriptionServiceInterface $userSubscriptionService */
            $userSubscriptionService = app(UserSubscriptionServiceInterface::class);
            $checkSubscription = $userSubscriptionService->checkSubscriptionValid($user->getKey());
        }
        if ($free || $boughtStatus || $checkSubscription) {
            $collectFile = [Tab::MEDIA_TAB_IMAGE, Tab::MEDIA_TAB_PDF];
        }

        $tab = $this->tabRepository->with([
            'user:id,name',
            'category:id,name',
            'reviewTabs.user.media',
            'media' => function ($query) use ($collectFile) {
                $query->whereIn('collection_name', $collectFile);
            },
            'user.media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            },
        ])->withCount(['orderItems as total_order_items'])->find($tabId);

        return $tab;
    }

    public function create(Request $request): Tab
    {
        $tab = $this->tabRepository->create(attributes: $request->only(['name', 'description', 'user_id', 'author', 'price', 'category_id', 'youtube_url', 'discount_money']));
        if ($images = $request->file('images')) {
            foreach ($images as $img) {
                $tab->addMedia($img)
                    ->toMediaCollection(Tab::MEDIA_TAB_IMAGE);
            }
        }
        if ($pdf = $request->file('pdf')) {
            $tab->addMedia($pdf)
                ->toMediaCollection(Tab::MEDIA_TAB_PDF);
        }

        return $tab;
    }

    public function update(int $id, Request $request)
    {
        $tab = $this->tabRepository->update($request->only([
            'name',
            'description',
            'user_id',
            'author',
            'price',
            'category_id',
            'youtube_url',
            'discount_money'
        ]), $id);

        if ($pdf = $request->file('pdf')) {
            $tab->clearMediaCollection(Tab::MEDIA_TAB_PDF);
            $tab->addMedia($pdf)
                ->toMediaCollection(Tab::MEDIA_TAB_PDF);
        }
        if ($images = $request->file('images')) {
            foreach ($images as $img) {
                $tab->addMedia($img)
                    ->toMediaCollection(Tab::MEDIA_TAB_IMAGE);
            }
        }
    }

    public function delete(int $id)
    {
        return $this->tabRepository->delete($id);
    }

    public function getTabByIds(array $ids)
    {
        return $this->tabRepository->whereIn('id', $ids)->get();
    }

    public function removeTabImage(int $tabId, int $mediaId): void
    {
        $tab = $this->tabRepository->find($tabId);
        $media = $tab->getMedia(Tab::MEDIA_TAB_IMAGE)->where('id', $mediaId)->first();
        if ($media) {
            $media->delete();
        }
    }

    public function getTabByUserId(int $userId)
    {
        $tabs = $this->tabRepository->with([
            'user:id,name',
            'category:id,name',
            'media' => function ($q) {
                $q->where('collection_name', Tab::MEDIA_TAB_IMAGE);
            }
        ])->where('user_id', $userId)->withCount(['orderItems as total_order_items'])->paginate(8);

        return $tabs;
    }
}
