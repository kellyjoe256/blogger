<?php

namespace App\Http\Controllers\BlogPost;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPost\CreateBlogPostRequest;
use App\Models\User;
use App\Repositories\BlogPost\BlogPostRepository;
use Illuminate\Http\RedirectResponse;

class BlogPostController extends Controller
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
        $blog_posts = $this->blogPostRepository->currentUserBlogPosts($sort_direction);

        return view('blog_posts.index', compact('blog_posts'));
    }

    public function store(CreateBlogPostRequest $request): RedirectResponse
    {
        /** @var User $current_user */
        $current_user = $request->user();
        $data = $request->only(['title', 'description', 'publication_date']);
        $current_user->blogPosts()->create($data);

        session()->flash('message', 'Blog post created successfully');

        return redirect()->route('dashboard.posts');
    }

    public function importPosts(): RedirectResponse
    {
        $blog_posts_collection = BlogPostRepository::importAndStorePosts();
        $flash_message = sprintf(
            "%d blog post(s) imported",
            $blog_posts_collection->count()
        );
        session()->flash('message', $flash_message);;

        return redirect()->route('dashboard');
    }
}
