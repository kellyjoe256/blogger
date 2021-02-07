<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Carbon;

class BlogPostObserver
{
    /**
     * Handle the BlogPost "creating" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        $publication_date = $blogPost->publication_date;

        $blogPost->title = ucfirst($blogPost->title);
        $blogPost->description = ucfirst($blogPost->description);
        $blogPost->publication_date = $publication_date ?: Carbon::now();
    }
}
