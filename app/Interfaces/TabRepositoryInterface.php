<?php

namespace App\Interfaces;

use App\Models\Tab;

interface TabRepositoryInterface
{
    public function getAllTabs();
    public function getTabById($id);
    public function createTab(array $data);
    public function updateTab(Tab $tab, array $data);
    public function deleteTab(Tab $tab);
}
