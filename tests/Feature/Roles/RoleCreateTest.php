<?php

use App\Models\User;

it('should show create form', function (User $admin) {
    $response = $this->actingAs($admin)->get(route('roles.create'));

    $response->assertStatus(200)->assertSeeText('Role Name');
})->with('admin');

it('should store a new role', function (User $admin) {
    $request = [
        'name' => 'Role 1',
        'description' => 'Something',
    ];

    $response = $this->actingAs($admin)->post(route('roles.store', $request));
    
    $this->assertDatabaseHas('roles', [
        'name' => $request['name'],
        'description' => $request['description'],
    ]);

    $response->assertStatus(302)->assertRedirect(route('roles.index'));
})->with('admin');
