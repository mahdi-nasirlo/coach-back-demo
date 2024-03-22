<?php

namespace Database\Factories;

use App\Enums\CoachStatusEnum;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coach>
 */
class CoachFactory extends Factory
{

    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "about_me" => $this->faker->paragraph(),
            "resume" => $this->faker->paragraph(),
            "job_experience" => $this->faker->boolean(40) ? $this->faker->paragraph() : "",
            "education_record" => $this->faker->boolean(40) ? $this->faker->paragraph() : "",
            "phone_number" => $this->faker->phoneNumber(),
            "status" => CoachStatusEnum::ACCEPTED->value
        ];
    }
}
