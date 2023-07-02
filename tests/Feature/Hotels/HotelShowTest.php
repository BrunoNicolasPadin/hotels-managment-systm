<?php

use App\Models\User;
use App\Models\Hotel;

it('should show data from hotel', function (User $admin) {
    $hotel = Hotel::factory()->create();

    $response = $this->actingAs($admin)->get(route('hotels.show', $hotel->id));

    $response->assertStatus(200)->assertSeeText($hotel->name);
})->with('admin');
