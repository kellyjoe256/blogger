<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\User;
use App\Repositories\BlogPost\BlogPostRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BlogPostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blogPostRepository = $this->app->make(BlogPostRepository::class);
    }

    /** @test */
    public function blog_post_method_returns_an_instance_of_blog_post_model(): void
    {
        /** @var BlogPost $blog_post */
        $blog_post = BlogPost::factory()->create();
        $found_blog_post = $this->blogPostRepository->blogPost($blog_post->id);

        $this->assertInstanceOf(Model::class, $found_blog_post);
        $this->assertInstanceOf(BlogPost::class, $found_blog_post);
    }

    /** @test */
    public function
    blog_post_method_throws_an_exception_when_given_id_that_does_not_exist():
    void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->blogPostRepository->blogPost(63);
    }

    /** @test */
    public function
    length_aware_paginator_instance_is_returned_for_blog_posts(): void
    {
        $blog_posts = $this->blogPostRepository->blogPosts();

        $this->assertInstanceOf(LengthAwarePaginator::class, $blog_posts);
    }

    /** @test */
    public function
    length_aware_paginator_instance_is_returned_for_current_user_blog_posts()
    : void
    {
        $this->actingAs(User::factory()->create());
        $blog_posts = $this->blogPostRepository->currentUserBlogPosts();

        $this->assertInstanceOf(LengthAwarePaginator::class, $blog_posts);
    }

    /** @test */
    public function
    current_user_if_not_admin_can_only_get_blog_posts_created_by_them(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        BlogPost::factory()->count(2)->create();
        /** @var EloquentCollection $user_blog_posts */
        $user_blog_posts = BlogPost::factory()->count(10)
            ->create(['user_id' => $user->id]);
        /** @var LengthAwarePaginator $current_user_blog_posts */
        $current_user_blog_posts = $this->blogPostRepository->currentUserBlogPosts();

        $this->assertEquals(
            $user_blog_posts->count(),
            $current_user_blog_posts->count()
        );

        foreach ($current_user_blog_posts as $blog_post) {
            $this->assertEquals($user->id, $blog_post->user_id);
        }
    }

    /** @test */
    public function current_user_if_admin_can_view_any_posts(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['super_user' => true]);
        $this->actingAs($user);

        BlogPost::factory()->count(3)->create();
        /** @var EloquentCollection $user_blog_posts */
        BlogPost::factory()->count(5)->create(['user_id' => $user->id]);

        /** @var LengthAwarePaginator $current_user_blog_posts */
        $current_user_blog_posts = $this->blogPostRepository->currentUserBlogPosts();

        $this->assertEquals(
            $current_user_blog_posts->count(),
            BlogPost::limit(BlogPostRepository::PER_PAGE)->count()
        );
    }

    /** @test */
    public function
    import_and_store_blog_posts_static_method_works_as_intended(): void
    {
        $result = BlogPostRepository::importAndStorePosts();

        $this->assertInstanceOf(Collection::class, $result);
    }
}
