<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->text(5),
            "description" => $this->faker->realTextBetween(),
            "start_date" => $this->faker->dateTimeBetween("-5 months", "now")->format("Y-m-d"),
            "created_at" => $this->faker->dateTimeBetween("-1 year", "-6 month"),
            "updated_at" => $this->faker->dateTimeBetween("-5 month", "now"),
        ];
    }
}
