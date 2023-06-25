<?php

use App\Models\Permission;
use App\Models\User;

it('should delete permission', function (User $admin) {
    $permission = Permission::factory()->create();
    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('permissions.destroy', $permission->id));

    $response->assertStatus(302)->assertRedirect(route('permissions.index'));
    $this->assertDatabaseMissing('permissions', [
        'id' => $permission->id,
    ]);
})->with('admin');
