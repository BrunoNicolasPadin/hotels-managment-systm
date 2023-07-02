<?php

namespace Database\Factories;

use App\Models\Lov;
use Illuminate\Database\Eloquent\Factories\Factory;

class LovFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lov::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'code' => $this->faker->name,
            'label' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }

    public function hotelType(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'hotelType',
            ];
        });
    }

    public function statusProcessCompleted(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'STATUS_PROCESS_COMPLETED',
                'type' => 'StatusProcess',
            ];
        });
    }

    public function statusProcessFailed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'STATUS_PROCESS_FAILED',
                'type' => 'TypeModel',
            ];
        });
    }

    public function statusProcessPending(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'STATUS_PROCESS_PENDING',
                'type' => 'TypeModel',
            ];
        });
    }

    public function typeProcessExport(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'TYPE_PROCESS_EXPORT',
                'type' => 'TypeProcess',
            ];
        });
    }

    public function typeProcessImport(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'TYPE_PROCESS_IMPORT',
                'type' => 'TypeProcess',
            ];
        });
    }

    public function typeModelHotel(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'Hotel',
                'type' => 'TypeModel',
                'label' => 'Hotel',
            ];
        });
    }
}
