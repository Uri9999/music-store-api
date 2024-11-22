<?php

namespace App\Interfaces;

use App\Models\Tab;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface TabServiceInterface
{
    public function index(Request $request);
    public function getNewTab(): Collection;
    public function getRandomTab(): Collection;
    public function show($id);
    public function create(array $data);
    public function update(Tab $tab, array $data);
    public function delete(Tab $tab);
    public function getTabByIds(array $ids);
}
