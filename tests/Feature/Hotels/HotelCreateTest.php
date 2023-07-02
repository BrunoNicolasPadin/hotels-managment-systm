<?php

use App\Models\Lov;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('should show hotel create form', function (User $admin) {
    $response = $this->actingAs($admin)->get(route('hotels.create'));

    $response->assertStatus(200)->assertSeeText('Create hotel');
})->with('admin');

it('should store a new hotel', function (User $admin, Lov $lov) {
    Storage::fake('public');
    $request = [
        'name' => 'Rivadavia',
        'type_id' => $lov->id,
        'photo' => UploadedFile::fake()->image('photo1.jpg'),
        'address' => 'Avenida 1234',
        'description' => 'something...',
    ];

    $response = $this->actingAs($admin)->post(route('hotels.store'), $request);

    $this->assertDatabaseHas('hotels', [
        'name' => $request['name'],
        'type_id' => $request['type_id'],
        'address' => $request['address'],
        'description' => $request['description'],
    ]);

    $response->assertStatus(302)->assertRedirect(route('hotels.index'));
})->with('admin', 'lovsForHotels');
