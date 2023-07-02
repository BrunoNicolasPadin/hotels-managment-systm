<?php

use App\Models\Hotel;
use App\Models\User;

it('should show a list of lovs', function (User $admin) {
    $hotel = Hotel::factory()->create();

    $response = $this->actingAs($admin)->get(route('hotels.index'), []);

    $response->assertStatus(200)->assertSeeText($hotel->name);
})->with('admin');
