<?php

namespace App\Interfaces;

use App\Models\Tab;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TabRepositoryInterface
{
    public function index(): LengthAwarePaginator;
    public function show($id): Tab;
    public function create(array $data): Tab;
    public function update(Tab $tab, array $data): Tab;
    public function delete(Tab $tab): Bool;
}
