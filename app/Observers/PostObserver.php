<?php

namespace App\Observers;

use App\Jobs\ReindexPostJob;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        dispatch(new ReindexPostJob($post->id));
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        dispatch(new ReindexPostJob($post->id));
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        logger('deleted ...');
        dispatch(new ReindexPostJob($post->id, true));
    }
}
