<?php

namespace App\Services;

use App\Interfaces\TagServiceInterface;
use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;

class TagService implements TagServiceInterface
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        return $this->tagRepository->getAllTags();
    }

    public function getTagById($id)
    {
        return $this->tagRepository->getTagById($id);
    }

    public function createTag(array $data)
    {
        return $this->tagRepository->createTag($data);
    }

    public function updateTag(Tag $tag, array $data)
    {
        return $this->tagRepository->updateTag($tag, $data);
    }

    public function deleteTag(Tag $tag)
    {
        return $this->tagRepository->deleteTag($tag);
    }
}
