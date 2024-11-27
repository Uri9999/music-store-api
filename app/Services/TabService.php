<?php

namespace App\Services;

use App\Interfaces\TabServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Models\Tab;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TabService implements TabServiceInterface
{
    protected $tabRepository;

    public function __construct(TabRepositoryInterface $tabRepository)
    {
        $this->tabRepository = $tabRepository;
    }

    public function index(Request $request)
    {
        $query = $this->tabRepository->with(['user:id,name', 'category:id,name']);
        if ($orderPrice = $request->get('orderPrice')) {
            $query = $query->orderBy('price', $orderPrice);
        }
        if ($search = $request->get('search')) {
            $query = $query->fullTextSearch($search);
        }

        return $query->paginate(config('app.paginate'));
    }

    public function getNewTab(): Collection
    {
        return $this->tabRepository->with(['user:id,name'])->orderBy('created_at', 'DESC')->take(12)->get();
    }

    public function getRandomTab(): Collection
    {
        return $this->tabRepository->with(['user:id,name'])->inRandomOrder()->take(12)->get();

    }

    public function show($id)
    {
        return $this->tabRepository->with(['user', 'category:id,name'])->find($id);
    }

    public function create(Request $request): Tab
    {
        $tab = $this->tabRepository->create(attributes: $request->only(['name', 'description', 'user_id', 'author', 'price', 'category_id', 'youtube_url']));
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

    public function update(Tab $tab, array $data)
    {
        return $this->tabRepository->update($data, $tab->getKey());
    }

    public function delete(Tab $tab)
    {
        return $this->tabRepository->delete($tab->getKey());
    }

    public function getTabByIds(array $ids)
    {
        return $this->tabRepository->whereIn('id', $ids)->get();
    }
}
