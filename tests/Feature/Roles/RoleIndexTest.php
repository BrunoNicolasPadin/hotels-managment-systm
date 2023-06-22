<?php

use App\Models\Role;
use App\Models\User;

it('should show a list of roles', function (User $admin) {
    $role = Role::factory()->create();

    $response = $this->actingAs($admin)->get(route('roles.index'), []);

    $response->assertStatus(200)->assertSeeText($role->name);
})->with('admin');
