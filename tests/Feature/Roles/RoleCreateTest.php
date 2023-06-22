<?php

use App\Models\User;

it('should show create form', function () {
    $admin = User::where('email', 'admin@gmail.com')->first();
    $response = $this->actingAs($admin)->get(route('roles.create'));

    $response->assertStatus(200)->assertSeeText('Role Name');
});
