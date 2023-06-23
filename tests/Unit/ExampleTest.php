<?php

use App\Models\User;

it('should show create form', function (User $admin) {
    $response = $this->actingAs($admin)->get(route('roles.create'));

    $response->assertStatus(200)->assertSeeText('Role Name');
})->with('admin');