<?php

namespace App\Http\Controllers;

use App\Repositories\BlogPost\BlogPostRepository;

class WelcomeController extends Controller
{
    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    public function index()
    {
        $sort_direction = publication_date_sort_direction(request('sort', ''));
        $blog_posts = $this->blogPostRepository->blogPosts($sort_direction);

        return view('welcome', compact('blog_posts'));
    }

    public function show($id)
    {
        $blog_post = $this->blogPostRepository->blogPost($id);

        return view('show_blog_post', compact('blog_post'));
    }
}
