<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function getAll()
    {
        return $this->postModel;
    }

    public function getById($id)
    {
        return $this->postModel->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            $this->postModel->create($data);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $model = $this->postModel->find($id);
            $model->update($data);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $model = $this->postModel->find($id);
            $model->delete();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
