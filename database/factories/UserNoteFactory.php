<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\UserNote>
 */
class UserNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contents' => fake()->paragraph,
            'user_id' => fn () => User::factory()->create()->id,
            'author_id' => fn () => User::factory()->admin()->create()->id
        ];
    }
}
