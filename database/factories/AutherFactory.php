<?php
namespace Database\Factories;

use App\Models\Auther;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AutherFactory extends Factory
{
    protected $model = Auther::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // You can modify this to generate hashed passwords or use a different approach
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
