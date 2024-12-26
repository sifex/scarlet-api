<?php

namespace Database\Factories;

use App\Enum\UserRole;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->name,
            'type' => UserRole::MEMBER,
            'installDir' => 'C:\Arma 3',
            'playerID' => $this->faker->numberBetween(70000000000000000, 80000000000000000),
        ];
    }

    public function admin(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserRole::LEADER,
            ];
        });
    }

    public function member(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserRole::MEMBER,
            ];
        });
    }
}
