<?php
namespace App\Services;

use App\Repositories\SearchRepositoryInterface;

class SearchService
{
    protected SearchRepositoryInterface $searchRepository;

    public function __construct(SearchRepositoryInterface $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function indexPost($post)
    {
        return $this->searchRepository->index($post);
    }

    public function bulkIndexPosts($posts)
    {
        return $this->searchRepository->bulkIndex($posts);
    }

    public function searchPosts($query)
    {
        return $this->searchRepository->search($query);
    }

    public function deletePostFromIndex($id)
    {
        return $this->searchRepository->delete($id);
    }
}

