<?php


namespace App\Repositories\BlogPost;


use App\Repositories\User\UserRepository;
use App\Support\BlogPost\BlogPostsImport;
use Illuminate\Database\Eloquent\Collection;

class BlogPostRepository
{
    /**
     * Import and store posts under the 'admin' username
     *
     * @return Collection
     */
    public static function importAndStorePosts(): Collection
    {
        $blog_posts = BlogPostsImport::import();
        $user = UserRepository::firstAdminOrCreate();

        return $user->blogPosts()->createMany($blog_posts);
    }
}
