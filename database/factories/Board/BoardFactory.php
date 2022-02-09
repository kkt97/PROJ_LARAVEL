<?php

namespace Database\Factories\Board;

use App\Models\Board\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    protected $model = Board::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => $this->faker->title,
            'content' => $this->faker->paragraph,
//            'image_name' => $this->faker->title,
//            'image_path' => $this->faker->title,
        ];
    }
}
