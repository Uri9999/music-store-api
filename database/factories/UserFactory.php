<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'dob' => now(),
            'status' => User::STATUS_ACTIVE,
            'gender' => Arr::random([1, 0]),
            'role_id' => Arr::random([2, 3]),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Trạng thái người dùng admin.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'dob' => now(),
            'status' => User::STATUS_ACTIVE,
            'gender' => 1,
            'role_id' => 1,
            'password' => Hash::make('admin123'), // Mật khẩu cho admin
        ]);
    }
}
