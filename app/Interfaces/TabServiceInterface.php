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
    public function showForUser($id, Request $request): ?Tab;
    public function create(Request $request): Tab;
    public function update(int $id, Request $request);
    public function delete(int $id);
    public function getTabByIds(array $ids);
    public function removeTabImage(int $tabId, int $mediaId): void;
}
