<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SearchService;
use Illuminate\Bus\Queueable;
use App\Models\Post;

class ReindexPostsBatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $posts;

    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    public function handle(SearchService $searchService): void
    {
            $searchService->bulkIndexPosts($this->posts);
    }
}
