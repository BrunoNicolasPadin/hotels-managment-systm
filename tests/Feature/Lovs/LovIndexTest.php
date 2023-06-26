<?php

use App\Models\Lov;
use App\Models\User;

it('should show a list of lovs', function (User $admin) {
    $lov = Lov::factory()->create();

    $response = $this->actingAs($admin)->get(route('lovs.index'), []);

    $response->assertStatus(200)->assertSeeText($lov->code);
})->with('admin');
