<?php

namespace App\Repositories;

interface SearchRepositoryInterface
{
    public function index($post);

    public function bulkIndex($posts);

    public function search($query);

    public function delete($id);
}
