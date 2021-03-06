<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Create Users using Faker
        $gender = $this->faker->randomElement(['m', 'f']);

        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'first_name'=>$this->faker->name,
            'last_name'=>$this->faker->name,
            'phone'=>$this->faker->numerify('########'),
            'gender'=>$gender,
            'age'=>$this->faker->numberBetween(12,99),
        ];
    }
}