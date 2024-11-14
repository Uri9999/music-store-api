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

    public function index()
    {
        return $this->tabRepository->index();
    }

    public function show($id)
    {
        return $this->tabRepository->show($id);
    }

    public function create(array $data)
    {
        return $this->tabRepository->create($data);
    }

    public function update(Tab $tab, array $data)
    {
        return $this->tabRepository->update($tab, $data);
    }

    public function delete(Tab $tab)
    {
        return $this->tabRepository->delete($tab);
    }
}
