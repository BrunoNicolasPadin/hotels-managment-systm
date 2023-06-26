<?php

use App\Models\User;

it('should show lov create form', function (User $admin) {
    $response = $this->actingAs($admin)->get(route('lovs.create'));

    $response->assertStatus(200)->assertSeeText('Code *');
})->with('admin');

it('should store a new lov', function (User $admin) {
    $request = [
        'code' => 'TEST',
        'type' => 'STATUS',
        'label' => 'Tests'
    ];

    $response = $this->actingAs($admin)->post(route('lovs.store', $request));

    $response->assertStatus(302)->assertRedirect(route('lovs.index'));
})->with('admin');
