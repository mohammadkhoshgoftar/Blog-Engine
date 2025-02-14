<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SearchService;
use App\Models\Post;

class ReindexPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postId;
    protected $delete;

    public function __construct($postId, $delete = false)
    {
        $this->postId = $postId;
        $this->delete = $delete;
    }

    public function handle(SearchService $searchService)
    {
        if ($this->delete) {
            $searchService->deletePostFromIndex($this->postId);
        } else {
            logger(12345600000000000000000000);
            $post = Post::find($this->postId);
            if ($post) {
                $searchService->indexPost($post);
            }
        }
    }
}

