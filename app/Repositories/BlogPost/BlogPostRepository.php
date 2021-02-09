<?php


namespace App\Repositories\BlogPost;


use App\Models\BlogPost;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Support\BlogPost\BlogPostsImport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BlogPostRepository
{
    public function blogPost($blog_post_id)
    {
        return Cache::rememberForever(
            "blog_post." . $blog_post_id,
            function () use ($blog_post_id) {
                return BlogPost::query()->select($this->columns())
                    ->with('user')
                    ->findOrFail($blog_post_id);
            }
        );
    }

    public function blogPosts(
        $publication_date_sort_direction = 'desc',
        $per_page = 10
    ): LengthAwarePaginator
    {
        $query_builder = BlogPost::query();
        $columns = array_diff($this->columns(), ['user_id']);
        $query_builder->select($columns);

        return $query_builder->orderBy(
            'publication_date',
            $publication_date_sort_direction
        )->paginate($per_page);
    }


    public function currentUserBlogPosts(
        $publication_date_sort_direction = 'desc',
        $per_page = 5
    ): LengthAwarePaginator
    {
        /** @var User $current_user */
        $current_user = auth()->user();
        $query_builder = BlogPost::query();
        $columns = array_diff($this->columns(), ['user_id', 'description']);
        $query_builder->select($columns);
        if (!$current_user->admin) {
            $query_builder->where('user_id', $current_user->id);
        }

        return $query_builder->orderBy(
            'publication_date',
            $publication_date_sort_direction
        )->paginate($per_page);
    }

    public function columns(): array
    {
        return [
            'id',
            'user_id',
            'title',
            'description',
            'publication_date',
        ];
    }

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
