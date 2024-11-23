<?php

namespace App\Services;

use App\Interfaces\TabServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Models\Tab;
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
        $query = $this->tabRepository;
        if ($orderPrice = $request->get('orderPrice')) {
            $query = $query->orderBy('price', $orderPrice);
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

    public function create(array $data)
    {
        return $this->tabRepository->create($data);
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
