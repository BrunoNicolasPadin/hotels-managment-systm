<?php

use App\Models\Permission;
use App\Models\User;

it('should show edit form', function (User $admin) {
    $permission = Permission::factory()->create();

    $response = $this->actingAs($admin)->get(route('permissions.edit', $permission->id));

    $response->assertStatus(200)->assertSeeText('Edit');
})->with('admin');

it('should update a permission', function (User $admin) {
    $permission = Permission::factory()->create();
    $request = [
        'name' => 'Permission updated',
    ];

    $response = $this->actingAs($admin)->put(route('permissions.update', $permission->id), $request);

    $response->assertStatus(302)->assertRedirect(route('permissions.index'));

    $this->assertDatabaseHas('permissions', [
        'name' => $request['name'],
    ]);
})->with('admin');
