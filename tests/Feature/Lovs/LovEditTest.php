<?php

use App\Models\Lov;
use App\Models\User;

it('should show edit form', function (User $admin) {
    $lov = Lov::factory()->create();

    $response = $this->actingAs($admin)->get(route('lovs.edit', $lov->id));

    $response->assertStatus(200)->assertSeeText('Edit lov');
})->with('admin');

it('should update a lov', function (User $admin) {
    $lov = Lov::factory()->create();
    $request = [
        'code' => 'TEST',
        'type' => 'STATUS',
        'label' => 'Tests',
    ];

    $response = $this->actingAs($admin)->put(route('lovs.update', $lov->id), $request);

    $response->assertStatus(302)->assertRedirect(route('lovs.index'));

    $this->assertDatabaseHas('lovs', [
        'code' => $request['code'],
        'type' => $request['type'],
        'label' => $request['label'],
    ]);
})->with('admin');
