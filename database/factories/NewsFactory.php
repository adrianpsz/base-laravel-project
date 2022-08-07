<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'message' => $this->faker->paragraph(2),
            'user_id' => function () {
                return create('App\Models\User');
            },
            'is_active' => 0,
        ];
    }
}
