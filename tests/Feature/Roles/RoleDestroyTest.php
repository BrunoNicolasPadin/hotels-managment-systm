<?php

use App\Models\Role;
use App\Models\User;

it('should delete role', function (User $admin) {
    $role = Role::factory()->create();
    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('roles.destroy', $role->id));

    $response->assertStatus(302)->assertRedirect(route('roles.index'));
    $this->assertDatabaseMissing('roles', [
        'id' => $role->id,
    ]);
})->with('admin');
