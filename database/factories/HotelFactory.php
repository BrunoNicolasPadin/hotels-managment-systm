<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Lov;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'description' => $this->faker->text,
            'type_id' => Lov::factory()->hotelType()->create()->id,
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
