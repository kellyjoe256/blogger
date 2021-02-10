<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardImportPostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function must_be_logged_in_to_import_posts(): void
    {
        $this->post(route('dashboard.import_posts'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_who_is_not_admin_cannot_import_posts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.import_posts'))
            ->assertStatus(401);
    }

    /** @test */
    public function logged_in_user_who_is_admin_can_import_posts(): void
    {
        $user = User::factory()->create(['super_user' => true]);

        $this->actingAs($user)->followingRedirects()
            ->post(route('dashboard.import_posts'))
            ->assertOk()
            ->assertSee('blog post(s) imported');
    }
}
