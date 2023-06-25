<?php

use App\Models\User;

it('should show create form', function (User $admin) {
    $response = $this->actingAs($admin)->get(route('permissions.create'));

    $response->assertStatus(200)->assertSeeText('Permission Name');
})->with('admin');

it('should store a new permission', function (User $admin) {
    $request = [
        'name' => 'Permission 1',
    ];

    $response = $this->actingAs($admin)->post(route('permissions.store', $request));

    $response->assertStatus(302)->assertRedirect(route('permissions.index'));
})->with('admin');
