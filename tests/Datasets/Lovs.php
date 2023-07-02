<?php

use App\Models\Lov;

dataset('lovsForHotels', [
    fn () => Lov::factory()->hotelType()->create(),
]);