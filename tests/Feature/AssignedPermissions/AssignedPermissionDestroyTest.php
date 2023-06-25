<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

it('should delete permission', function (User $admin) {
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();
    $role->givePermissionTo($permission->id);
    $this->assertDatabaseHas('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('assigned-permissions.destroy', [$role->id, $permission->id]));

    $response->assertStatus(302)->assertRedirect(route('assigned-permissions.index', $role->id));
    $this->assertDatabaseMissing('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
    ]);
})->with('admin');
