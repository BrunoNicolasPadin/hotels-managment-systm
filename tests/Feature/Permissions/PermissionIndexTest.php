<?php

use App\Models\Permission;
use App\Models\User;

it('should show a list of permissions', function (User $admin) {
    $permission = Permission::factory()->create();

    $response = $this->actingAs($admin)->get(route('permissions.index'), []);

    $response->assertStatus(200)->assertSeeText($permission->name);
})->with('admin');