<?php

namespace Database\Factories;

use App\Models\GameUser;
use App\Models\LeaderBoard;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaderBoardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeaderBoard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_user_id' =>GameUser::factory(),
            'score' => $this->faker->numberBetween(100,1000),
            'last_update_time' => $this->faker->dateTimeThisMonth('now')
        ];
    }
}
