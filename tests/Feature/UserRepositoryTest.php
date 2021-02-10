<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function that_first_or_create_method_returns_model_instance(): void
    {
        $data = [
            'name' => 'John Doe',
            'password' => Hash::make('password'),
        ];

        /** @var User $user */
        $user = UserRepository::firstOrCreate(
            'email',
            'johndoe@example.com',
            $data
        );

        $this->assertInstanceOf(Model::class, $user);
    }

    /** @test */
    public function that_first_or_create_method_returns_user_instance(): void
    {
        $data = [
            'name' => 'John Doe',
            'password' => Hash::make('password'),
        ];

        /** @var User $user */
        $user = UserRepository::firstOrCreate(
            'email',
            'johndoe@example.com',
            $data
        );

        $this->assertInstanceOf(User::class, $user);
    }

    /** @test */
    public function
    that_first_admin_or_create_method_creates_and_returns_admin_user(): void
    {
        /** @var User $user */
        $user = UserRepository::firstAdminOrCreate();

        $this->assertInstanceOf(Model::class, $user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->super_user);
        $this->assertTrue($user->admin);
    }
}
