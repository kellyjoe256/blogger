<?php


namespace App\Repositories\BlogPost;


use App\Models\BlogPost;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Support\BlogPost\BlogPostsImport;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class BlogPostRepository
{
    const PER_PAGE = 10;

    public function blogPost($blog_post_id): BlogPost
    {
        $cache_key = "blog_post." . $blog_post_id;

        return $this->getResults(
            $cache_key,
            function () use ($blog_post_id) {
                return BlogPost::query()->select($this->columns())
                    ->with('user')
                    ->findOrFail($blog_post_id);
            }
        );
    }

    public function blogPosts(
        $publication_date_sort_direction = 'desc'
    ): LengthAwarePaginator
    {
        $cache_key = $this->generateBlogPostsCacheKey(request());

        return $this->getResults(
            $cache_key,
            function () use ($publication_date_sort_direction) {
                $query_builder = BlogPost::query();
                $columns = array_diff($this->columns(), ['user_id']);
                $query_builder->select($columns);

                return $query_builder->orderBy(
                    'publication_date',
                    $publication_date_sort_direction
                )->paginate(static::PER_PAGE);
            }
        );
    }

    public function currentUserBlogPosts(
        $publication_date_sort_direction = 'desc'
    ): LengthAwarePaginator
    {
        /** @var User $current_user */
        $current_user = auth()->user();
        $cache_key = $this->generateBlogPostsCacheKey(request(), [
            'user_id' => $current_user->id,
        ]);

        return $this->getResults(
            $cache_key,
            function () use ($current_user, $publication_date_sort_direction) {
                $query_builder = BlogPost::query();
                $columns = array_diff($this->columns(), ['description']);
                $query_builder->select($columns);
                if (!$current_user->admin) {
                    $query_builder->where('user_id', $current_user->id);
                }

                return $query_builder->orderBy(
                    'publication_date',
                    $publication_date_sort_direction
                )->paginate(static::PER_PAGE);
            }
        );
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

    private function columns(): array
    {
        return [
            'id',
            'user_id',
            'title',
            'description',
            'publication_date',
        ];
    }

    private function getResults(string $cache_key, Closure $callback)
    {
        $expiration_time = Carbon::now()->addMinutes(60);

        return Cache::remember($cache_key, $expiration_time, $callback);
    }

    private function generateBlogPostsCacheKey(
        Request $request,
        array $merge = []
    ): string
    {
        $query_string_keys_values = $request->query->all();
        $blog_posts_cache_key = 'blog_posts';
        $all_keys_values = array_merge($query_string_keys_values, $merge);

        foreach ($all_keys_values as $key => $value) {
            $blog_posts_cache_key .= sprintf(".%s.%s", $key, $value);
        }

        return $blog_posts_cache_key;
    }
}
