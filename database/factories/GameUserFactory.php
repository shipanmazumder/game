<?php

namespace Database\Factories;

use App\Models\GameUser;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'user_unique_id' => Str::random(10),
            'image' => $this->faker->imageUrl('http://lorempixel.com/128/128/cats/'),
            'last_login_time' => $this->faker->dateTimeThisMonth('now'),
            'last_message_time' => $this->faker->date('Y-m-d','now'),
            'message_count' => 0,

        ];
    }
}
