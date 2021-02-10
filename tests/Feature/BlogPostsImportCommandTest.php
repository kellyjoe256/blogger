<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPostsImportCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function command_works(): void
    {
        $this->artisan('import:posts')
            ->assertExitCode(0);
    }
}
