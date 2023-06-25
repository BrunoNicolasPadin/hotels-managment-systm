<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

it('should show a list of permissions to a role', function (User $admin) {
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();
    $role->givePermissionTo($permission->id);

    $response = $this->actingAs($admin)->get(route('assigned-permissions.index', $role->id), []);

    $response->assertStatus(200)->assertSeeText($permission->name);
})->with('admin');
