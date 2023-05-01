<?php

namespace Database\Factories;

use App\Settings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingsFactory extends Factory
{
    protected $model = Settings::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'launcher_image_url' => $this->faker->imageUrl(),
            'welcome_image_url' => $this->faker->imageUrl(),
            'changed_by' => $this->faker->randomNumber(),
        ];
    }
}
