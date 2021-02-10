<?php

namespace Tests\Feature;

use App\Support\Services\BlogPost\BlogPostsImportService;
use Tests\TestCase;

class BlogPostsImportServiceTest extends TestCase
{
    /**
     * @var BlogPostsImportService
     */
    private $blogPostsImportService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blogPostsImportService = $this->app
            ->make(BlogPostsImportService::class);
    }

    /** @test */
    public function service_must_return_valid_data(): void
    {
        $data = $this->blogPostsImportService->import();

        $this->assertIsArray($data);
    }
}
