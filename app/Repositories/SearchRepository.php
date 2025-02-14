<?php

namespace App\Repositories;

use Elastic\Elasticsearch\ClientBuilder;
use App\Models\Post;

class SearchRepository implements SearchRepositoryInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts([config('elasticsearch.host')])->build();
    }

    public function index($post)
    {
        return $this->client->index([
            'index' => 'posts',
            'id'    => $post->id,
            'body'  => $post->toArray()
        ]);
    }

    public function bulkIndex($posts): void
    {
        $bulkData = [];

        foreach ($posts as $post) {
            $bulkData[] = [
                'index' => [
                    '_index' => 'posts',
                    '_id'    => $post->id,
                ]
            ];
            $bulkData[] = $post->toArray();
        }

        if (!empty($bulkData)) {
            $this->client->bulk(['body' => $bulkData]);
        }
    }

    public function search($query)
    {
        $params = [
            'index' => 'posts',
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'  => $query,
                        'fields' => ['title', 'category', 'body']
                    ]
                ]
            ]
        ];
        return $this->client->search($params);
    }

    public function delete($id)
    {
        return $this->client->delete([
            'index' => 'posts',
            'id'    => $id
        ]);
    }
}
