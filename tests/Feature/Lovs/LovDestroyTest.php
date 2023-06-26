<?php

use App\Models\Lov;
use App\Models\User;

it('should delete lov', function (User $admin) {
    $lov = Lov::factory()->create();
    $this->assertDatabaseHas('lovs', [
        'id' => $lov->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('lovs.destroy', $lov->id));

    $response->assertStatus(302)->assertRedirect(route('lovs.index'));
    $this->assertDatabaseMissing('lovs', [
        'id' => $lov->id,
    ]);
})->with('admin');
