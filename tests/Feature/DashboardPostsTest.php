<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function must_be_logged_in_to_access_dashboard_posts_page(): void
    {
        $this->post(route('dashboard.posts'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function must_be_able_to_see_form_to_create_a_blog_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('dashboard.posts'))
            ->assertSee(['title', 'description', 'Create Blog Post']);
    }


    /** @test */
    public function
    required_fields_must_be_provided_in_order_to_create_blog_post(): void
    {
        $data = $this->data();
        $user = User::factory()->create();

        collect($data)
            ->keys()
            ->each(function ($field) use ($user, $data) {
                $this->actingAs($user)
                    ->post(
                        route('dashboard.posts'),
                        array_merge($data, [$field => ''])
                    )->assertSessionHasErrors([$field]);
            });
    }

    /** @test */
    public function blog_post_is_created_successfully(): void
    {
        $data = $this->data();
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('dashboard.posts'), $data)
            ->assertOk()
            ->assertSee(['created successfully', $data['title']]);
    }

    /** @test */
    public function blog_post_created_belongs_to_the_current_user(): void
    {
        $data = $this->data();
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('dashboard.posts'), $data)
            ->assertOk();

        /** @var BlogPost $created_blog_post */
        $created_blog_post = BlogPost::orderBy('created_at', 'desc')->first();

        $this->assertEquals($user->id, $created_blog_post->user_id);
    }

    /** @test */
    public function
    must_be_provided_with_ability_to_sort_blog_posts_if_any_exist(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('dashboard.posts'), $this->data())
            ->assertOk();

        $this->actingAs($user)
            ->get(route('dashboard.posts'))
            ->assertSee(['oldest', 'newest']);
    }

    /** @test */
    public function must_be_able_to_sort_blog_posts(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $blog_post_titles = [];

        // create three blog posts belonging to the current user
        for ($i = 0; $i < 3; $i += 1) {
            /** @var BlogPost $blog_post */
            $blog_post = BlogPost::factory()->create(['user_id' => $user->id]);
            array_push($blog_post_titles, $blog_post->title);
        }

        $this->actingAs($user)
            ->get(route('dashboard.posts', ['sort' => 'oldest']))
            ->assertSeeInOrder($blog_post_titles);

        $this->actingAs($user)
            ->get(route('dashboard.posts', ['sort' => 'newest']))
            ->assertSeeInOrder(array_reverse($blog_post_titles));
    }

    private function data(): array
    {
        return [
            'title' => 'Hello, world',
            'description' => 'Lorem ipsum dolor sit amet.',
        ];
    }
}
