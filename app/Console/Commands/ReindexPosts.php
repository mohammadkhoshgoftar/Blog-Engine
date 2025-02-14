<?php

namespace App\Console\Commands;

use App\Jobs\ReindexPostsBatchJob;
use Illuminate\Console\Command;
use App\Models\Post;

class ReindexPosts extends Command
{
    protected $signature = 'posts:reindex';
    protected $description = 'Reindex all posts in Elasticsearch using batch queue';

    public function handle()
    {
        $this->info('Dispatching batch jobs for reindexing posts...');

        Post::query()->chunk(5000, function ($posts) {
            dispatch(new ReindexPostsBatchJob($posts));
        });

        $this->info('All batch reindex jobs have been dispatched.');
    }
}
