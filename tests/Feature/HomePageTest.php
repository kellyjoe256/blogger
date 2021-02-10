<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_be_open_to_public(): void
    {
        $this->get(route('home'))
            ->assertOk();
    }

    /** @test */
    public function even_authenticated_users_should_be_able_to_visit_page():
    void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('home'))
            ->assertOk();
    }

    /** @test */
    public function no_blog_posts_in_the_database(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('No posts available');
    }

    /** @test */
    public function blog_post_in_the_database(): void
    {
        /** @var BlogPost $blog_post */
        $blog_post = BlogPost::factory()->create();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($blog_post->title);
    }

    /** @test */
    public function
    must_be_provided_with_ability_to_sort_blog_posts_if_any_exist(): void
    {
        BlogPost::factory()->create();

        $this->get(route('home'))
            ->assertSee(['oldest', 'newest']);
    }

    /** @test */
    public function must_be_able_to_sort_blog_posts(): void
    {
        $blog_post_titles = [];

        for ($i = 0; $i < 3; $i += 1) {
            /** @var BlogPost $blog_post */
            $blog_post = BlogPost::factory()->create();
            array_push($blog_post_titles, $blog_post->title);
        }

        $this->get(route('home', ['sort' => 'oldest']))
            ->assertSeeInOrder($blog_post_titles);

        $this->get(route('home', ['sort' => 'newest']))
            ->assertSeeInOrder(array_reverse($blog_post_titles));
    }

    /** @test */
    public function
    must_be_provide_ability_for_pagination_if_enough_blog_posts_exist(): void
    {
        BlogPost::factory()->count(150)->create();

        $this->get(route('home', ['page' => 2]))
            ->assertSee(['Previous', 'Next']);
    }

    /** @test */
    public function should_load_in_less_than_300ms_on_subsequent_requests():
    void
    {
        $route = route('home');

        $this->get($route)
            ->assertOk();

        for ($i = 0; $i < 10; $i += 1) {
            $start_time = microtime(true);
            $this->get($route);
            $end_time = microtime(true);

            $this->assertLessThan(0.3, ($end_time - $start_time));
        }
    }
}
