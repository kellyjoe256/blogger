<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    /**
     * Handle the BlogPost "creating" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost): void
    {
        Cache::clear();

        $publication_date = $blogPost->publication_date;

        $blogPost->title = ucfirst($blogPost->title);
        $blogPost->description = ucfirst($blogPost->description);
        $blogPost->publication_date = $publication_date ?: Carbon::now();
    }

//    /**
//     * Handle the BlogPost "updating" event.
//     *
//     * @param BlogPost $blogPost
//     * @return void
//     */
//    public function updating(BlogPost $blogPost): void
//    {
//        $this->deleteBlogPostCacheKey($blogPost);
//    }
//
//    /**
//     * Handle the BlogPost "deleting" event.
//     *
//     * @param BlogPost $blogPost
//     * @return void
//     */
//    public function deleting(BlogPost $blogPost): void
//    {
//        $this->deleteBlogPostCacheKey($blogPost);
//    }
//
//    private function deleteBlogPostCacheKey(BlogPost $blogPost): void
//    {
//        Cache::delete("blog_post." . $blogPost->id);
//    }
}
