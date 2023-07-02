<?php

use App\Models\Hotel;
use App\Models\Lov;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('should show edit form', function (User $admin) {
    $hotel = Hotel::factory()->create();

    $response = $this->actingAs($admin)->get(route('hotels.edit', $hotel->id));

    $response->assertStatus(200)->assertSeeText('Edit hotel');
})->with('admin');

it('should update a lov', function (User $admin, Lov $lov) {
    $hotel = Hotel::factory()->create();
    Storage::fake('public');
    $request = [
        'name' => 'Rivadavia',
        'type_id' => $lov->id,
        'photo' => UploadedFile::fake()->image('photo1.jpg'),
        'address' => 'Avenida 1234',
        'description' => 'something...',
    ];

    $response = $this->actingAs($admin)->put(route('hotels.update', $hotel->id), $request);

    $this->assertDatabaseHas('hotels', [
        'name' => $request['name'],
        'type_id' => $request['type_id'],
        'address' => $request['address'],
        'description' => $request['description'],
    ]);

    $response->assertStatus(302)->assertRedirect(route('hotels.index'));
})->with('admin', 'lovsForHotels');
