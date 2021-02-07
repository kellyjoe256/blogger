<?php


namespace App\Support\Services\BlogPost;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class BlogPostsImportService
{
    /**
     * Get latest posts from api endpoint
     *
     * @return array
     */
    public function import(): array
    {
        $response = Http::get(config('custom.posts_api_endpoint'));
        $latest_blog_posts = $response->json()['data'] ?? [];

        return array_map(function ($blog_post) {
            $title = $blog_post['title'] ?? 'Title';
            $description = $blog_post['description'] ?? 'Description';
            $publication_date = $blog_post['publication_date'] ?? null;
            $publication_date = $publication_date
                ? Carbon::parse($publication_date) : Carbon::now();

            return compact('title', 'description', 'publication_date');
        }, $latest_blog_posts);
    }
}
