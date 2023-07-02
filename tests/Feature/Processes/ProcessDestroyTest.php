<?php

use App\Models\Process;
use App\Models\User;

it('should delete process', function (User $admin) {
    $process = Process::factory()->create();
    $this->assertDatabaseHas('processes', [
        'id' => $process->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('processes.destroy', $process->id));

    $response->assertStatus(302)->assertRedirect(route('processes.index'));
    $this->assertDatabaseMissing('processes', [
        'id' => $process->id,
    ]);
})->with('admin');
