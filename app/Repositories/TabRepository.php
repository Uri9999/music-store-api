<?php

namespace App\Repositories;

use App\Interfaces\TabRepositoryInterface;
use App\Models\Tab;

class TabRepository implements TabRepositoryInterface
{
    public function getAllTabs()
    {
        return Tab::all();
    }

    public function getTabById($id)
    {
        return Tab::findOrFail($id);
    }

    public function createTab(array $data)
    {
        return Tab::create($data);
    }

    public function updateTab(Tab $tab, array $data)
    {
        $tab->update($data);
        return $tab;
    }

    public function deleteTab(Tab $tab)
    {
        $tab->delete();
        return true;
    }
}
