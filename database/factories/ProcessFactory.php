<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Lov;
use App\Models\Process;
use App\Models\User;

class ProcessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Process::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type_id' => Lov::factory()->typeProcessExport()->create()->id,
            'status_id' => Lov::factory()->statusProcessCompleted()->create()->id,
            'user_id' => User::factory()->create()->id,
            'total' => $this->faker->randomNumber(),
            'file' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'log' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'model_id' => Lov::factory()->typeModelHotel()->create()->id,
        ];
    }
}
