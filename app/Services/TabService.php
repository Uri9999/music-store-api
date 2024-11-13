<?php

namespace App\Services;

use App\Interfaces\TabServiceInterface;
use App\Interfaces\TabRepositoryInterface;
use App\Models\Tab;

class TabService implements TabServiceInterface
{
    protected $tabRepository;

    public function __construct(TabRepositoryInterface $tabRepository)
    {
        $this->tabRepository = $tabRepository;
    }

    public function getAllTabs()
    {
        return $this->tabRepository->getAllTabs();
    }

    public function getTabById($id)
    {
        return $this->tabRepository->getTabById($id);
    }

    public function createTab(array $data)
    {
        return $this->tabRepository->createTab($data);
    }

    public function updateTab(Tab $tab, array $data)
    {
        return $this->tabRepository->updateTab($tab, $data);
    }

    public function deleteTab(Tab $tab)
    {
        return $this->tabRepository->deleteTab($tab);
    }
}
