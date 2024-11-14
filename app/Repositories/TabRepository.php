<?php

namespace App\Repositories;

use App\Interfaces\TabRepositoryInterface;
use App\Models\Tab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TabRepository implements TabRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        return Tab::paginate(config('app.paginate'));
    }

    public function show($id): Tab
    {
        return Tab::findOrFail($id);
    }

    public function create(array $data): Tab
    {
        return Tab::create($data);
    }

    public function update(Tab $tab, array $data): Tab
    {
        $tab->update($data);
        return $tab;
    }

    public function delete(Tab $tab): Bool
    {
        $tab->delete();
        return true;
    }
}
