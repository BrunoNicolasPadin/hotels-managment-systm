<?php

use App\Models\Role;
use App\Models\User;

it('should show edit form', function (User $admin) {
    $role = Role::factory()->create();

    $response = $this->actingAs($admin)->get(route('roles.edit', $role->id));

    $response->assertStatus(200)->assertSeeText('Edit');
})->with('admin');

it('should update a role', function (User $admin) {
    $role = Role::factory()->create();
    $request = [
        'name' => 'Role updated',
        'description' => 'Something updated',
    ];

    $response = $this->actingAs($admin)->put(route('roles.update', $role->id), $request);

    $response->assertStatus(302)->assertRedirect(route('roles.index'));

    $this->assertDatabaseHas('roles', [
        'name' => $request['name'],
        'description' => $request['description'],
    ]);
})->with('admin');
