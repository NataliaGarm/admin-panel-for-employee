<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Position;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'img' => $this->faker->imageUrl($width = 640, $height = 480),
            'name' => $this->faker->name,
            'phone' => $this->faker->numerify('+380 (##) ### ## ##'),
            'email' => $this->faker->unique()->email,
            'position' => Position::factory(),
            'employment_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'salary' => $this->faker->numberBetween($min = 0, $max = 500.000),
            'head' =>null, //Employee::factory(),
            'admin_created_id' => User::factory(),
            'admin_updated_id' => User::factory(),
        ];
    }
}