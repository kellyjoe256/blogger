<?php

namespace Tests\Unit;

use App\Support\BlogPost\BlogPostsImport;
use App\Support\Services\BlogPost\BlogPostsImportService;
use Exception;
use Tests\TestCase;

class BlogPostsImportFacadeTest extends TestCase
{
    /** @test */
    public function service_used_must_be_a_blog_posts_import_service(): void
    {
        $service = BlogPostsImport::service();

        $this->assertInstanceOf(BlogPostsImportService::class, $service);
    }

    /** @test */
    public function
    calling_an_undefined_method_through_facade_on_service_must_throw_exception(): void
    {
        $this->expectException(Exception::class);

        BlogPostsImport::test();
    }
}
