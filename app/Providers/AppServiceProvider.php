<?php

namespace App\Providers;

use App\Repositories\SearchRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SearchRepository;
use App\Repositories\PostRepository;
use App\Observers\PostObserver;
use Illuminate\Http\Response;
use App\Models\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(SearchRepositoryInterface::class, SearchRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Post::observe(PostObserver::class);

        Response::macro('success', function($message = 'Information received successfully', $data = null) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ]);
        });

        Response::macro('error', function($message, $data = null, $code = 500) {
            return response()->json([
                'status' => false,
                'error' => $message,
                'data' => $data,
            ], $code);
        });
    }
}
