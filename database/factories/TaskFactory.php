<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->text(5),
            "description" => $this->faker->realTextBetween(),
            "start_date" => $this->faker->dateTimeBetween("-5 months", "now")->format("Y-m-d"),
            "status" => $this->faker->randomElement(array_column(TaskStatus::cases(), "value")),
            "created_at" => $this->faker->dateTimeBetween("-1 year", "-6 month"),
            "updated_at" => $this->faker->dateTimeBetween("-5 month", "now"),
        ];
    }
}
