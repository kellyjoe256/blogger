<?php


namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
    /**
     * @param string $column
     * @param mixed $value
     * @param array $values
     * @return User
     */
    public static function firstOrCreate($column, $value, array $values): User
    {
        return User::firstOrCreate([$column => $value], $values);
    }

    /**
     * @param array $values
     * @return User
     */
    public static function firstAdminOrCreate(array $values = []): User
    {
        if (!count($values)) {
            $values = [
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ];
        }
        $final_values = array_merge($values, [
            'super_user' => true,
        ]);

        return static::firstOrCreate('username', 'admin', $final_values);
    }
}
