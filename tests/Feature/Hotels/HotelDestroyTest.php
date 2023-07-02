<?php

use App\Models\Hotel;
use App\Models\User;

it('should delete hotel', function (User $admin) {
    $hotel = Hotel::factory()->create();
    $this->assertDatabaseHas('hotels', [
        'id' => $hotel->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('hotels.destroy', $hotel->id));

    $response->assertStatus(302)->assertRedirect(route('hotels.index'));
    $this->assertSoftDeleted('hotels', [
        'id' => $hotel->id,
    ]);
})->with('admin');

it('should restore hotel', function (User $admin) {
    $hotel = Hotel::factory()->create();
    $this->assertDatabaseHas('hotels', [
        'id' => $hotel->id,
    ]);

    $this->actingAs($admin)->delete(route('hotels.destroy', $hotel->id));
    $this->assertSoftDeleted('hotels', [
        'id' => $hotel->id,
    ]);

    $response = $this->actingAs($admin)->put(route('hotels.restore', $hotel->id));
    $response->assertStatus(302)->assertRedirect(route('hotels.index'));
    $this->assertDatabaseHas('hotels', [
        'id' => $hotel->id,
    ]);
})->with('admin');
