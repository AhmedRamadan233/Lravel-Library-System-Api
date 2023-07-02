<?php
namespace Database\Factories;

use App\Models\Book;
use App\Models\Auther;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'author_id' => Auther::factory()->create()->id,
            'publisher' => $this->faker->company,
            'publishing_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'category_id' => Category::factory()->create()->id,
            'edition' => $this->faker->randomElement(['First Edition', 'Second Edition', 'Third Edition']),
            'pages' => $this->faker->numberBetween(100, 1000),
            'num_of_copies' => $this->faker->numberBetween(1, 10),
            'available' => $this->faker->numberBetween(0, 5),
            'shelf_num' => $this->faker->numberBetween(1, 100),
            'num_of_borrowing' => $this->faker->numberBetween(0, 50),
            'num_of_reading' => $this->faker->numberBetween(0, 50),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
