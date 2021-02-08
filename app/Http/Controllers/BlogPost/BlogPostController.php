<?php

namespace App\Http\Controllers\BlogPost;

use App\Http\Controllers\Controller;
use App\Repositories\BlogPost\BlogPostRepository;
use Illuminate\Http\RedirectResponse;

class BlogPostController extends Controller
{
    public function importPosts(): RedirectResponse
    {
        $blog_posts_collection = BlogPostRepository::importAndStorePosts();
        $flash_message = sprintf(
            "%d blog post(s) imported",
            $blog_posts_collection->count()
        );
        session()->flash('message', $flash_message);;

        return redirect()->route('dashboard');
    }
}
