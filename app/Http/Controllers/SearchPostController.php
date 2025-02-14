<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use App\Models\Post;

class SearchPostController extends Controller
{
    private SearchService $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->searchService->searchPosts($request);


    }
}
