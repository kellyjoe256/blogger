<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = UserRepository::firstAdminOrCreate();

        return [
            'title' => $this->faker->unique()->sentence,
            'description' => $this->faker->unique()->paragraph,
            'publication_date' => Carbon::now(),
            'user_id' => $user->id,
        ];
    }
}
