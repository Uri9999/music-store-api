<?php

namespace App\Interfaces;

use App\Models\Tab;

interface TabServiceInterface
{
    public function index();
    public function show($id);
    public function create(array $data);
    public function update(Tab $tab, array $data);
    public function delete(Tab $tab);
}
