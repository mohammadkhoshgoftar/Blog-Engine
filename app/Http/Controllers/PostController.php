<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $posts = $this->postService->getAllPosts()->paginate($request->get('per_page', 10));
        if ($posts)
            return Response::success('Posts fetched', PostCollection::make($posts));
        else
            return Response::error('Failed to fetch posts');
    }

    public function store(StorePostRequest $request)
    {
        $result = $this->postService->createPost($request->validated());
        if ($result)
            return Response::success('Post created');
        else
            return Response::error('Failed to create post');
    }

    public function show($id)
    {
        $result = $this->postService->getPostById($id);
        if ($result)
            return Response::success('Post fetched', PostResource::make($result));
        else
            return Response::error('Failed to fetch post');
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $result = $this->postService->updatePost($id, $request->validated());
        if ($result)
            return Response::success('Post updated');
        else
            return Response::error('Failed to update post');
    }

    public function destroy($id)
    {
        $result = $this->postService->deletePost($id);
        if ($result)
            return Response::success('Post deleted');
        else
            return Response::error('Failed to delete post');
    }
}
