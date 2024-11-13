<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function getAllTags()
    {
        return Tag::all();
    }

    public function getTagById($id)
    {
        return Tag::findOrFail($id);
    }

    public function createTag(array $data)
    {
        return Tag::create($data);
    }

    public function updateTag(Tag $tag, array $data)
    {
        $tag->update($data);
        return $tag;
    }

    public function deleteTag(Tag $tag)
    {
        $tag->delete();
        return true;
    }
}
