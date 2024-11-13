<?php

namespace App\Interfaces;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function getAllTags();
    public function getTagById($id);
    public function createTag(array $data);
    public function updateTag(Tag $tag, array $data);
    public function deleteTag(Tag $tag);
}
