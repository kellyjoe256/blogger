<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowSingleBlogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_be_open_to_public(): void
    {
        /** @var BlogPost $blog_post */
        $blog_post = BlogPost::factory()->create();

        $this->get(route('show_blog_post', $blog_post->id))
            ->assertOk();
    }

    /** @test */
    public function even_authenticated_users_should_be_able_to_visit_page():
    void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var BlogPost $blog_post */
        $blog_post = BlogPost::factory()->create();

        $this->actingAs($user)
            ->get(route('show_blog_post', $blog_post->id))
            ->assertOk();
    }

    /** @test */
    public function
    must_return_status_of_not_found_if_blog_post_does_not_exist(): void
    {
        $this->get(route('show_blog_post', 15))
            ->assertNotFound();
    }

    /** @test */
    public function should_load_in_less_than_250ms_on_subsequent_requests():
    void
    {
        /** @var BlogPost $blog_post */
        $blog_post = BlogPost::factory()->create();
        $blog_post_route = route('show_blog_post', $blog_post->id);

        $this->get($blog_post_route)
            ->assertOk();

        for ($i = 0; $i < 10; $i += 1) {
            $start_time = microtime(true);
            $this->get($blog_post_route);
            $end_time = microtime(true);

            $this->assertLessThan(0.25, ($end_time - $start_time));
        }
    }
}
