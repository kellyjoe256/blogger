<?php

namespace App\Console\Commands;

use App\Repositories\BlogPost\BlogPostRepository;
use Illuminate\Console\Command;

class BlogPostsImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import latest posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Importing blog posts. This might take a while...');

        BlogPostRepository::importAndStorePosts();

        $this->info("Done!");
    }
}
