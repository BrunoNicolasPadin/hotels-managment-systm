<?php

use App\Models\Process;
use App\Models\User;

it('should show a list of processes', function (User $admin) {
    $process = Process::factory()->create();

    $response = $this->actingAs($admin)->get(route('processes.index'), []);

    $response->assertStatus(200)->assertSeeText($process->file);
})->with('admin');
