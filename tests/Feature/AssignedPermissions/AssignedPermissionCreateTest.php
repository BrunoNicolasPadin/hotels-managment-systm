<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

it('should show assigned permissions form', function (User $admin) {
    $role = Role::factory()->create();
    $response = $this->actingAs($admin)->get(route('assigned-permissions.create', $role->id));

    $response->assertStatus(200)->assertSeeText('Select the permission');
})->with('admin');

it('should assign a new permission', function (User $admin) {
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();
    $request = [
        'permission_id' => $permission->id,
    ];

    $response = $this->actingAs($admin)->post(route('assigned-permissions.store', $role->id), $request);

    $response->assertStatus(302)->assertRedirect(route('assigned-permissions.index', $role->id));
})->with('admin');
