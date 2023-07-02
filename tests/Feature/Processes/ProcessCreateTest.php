<?php

use App\Models\Lov;
use App\Models\User;

it('should store a new process', function (User $admin) {
    $statusProcessCompleted = Lov::factory()->statusProcessCompleted()->create();
    Lov::factory()->statusProcessFailed()->create();
    $typeProcessExport = Lov::factory()->typeProcessExport()->create();
    $statusProcessPending = Lov::factory()->statusProcessPending()->create();
    $typeModelHotel = Lov::factory()->typeModelHotel()->create();

    $request = [
        'type' => $typeProcessExport->code,
        'status' => $statusProcessPending->code,
        'model' => $typeModelHotel->code,
    ];

    $response = $this->actingAs($admin)->post(route('processes.store'), $request);

    $this->assertDatabaseHas('processes', [
        'type_id' => $typeProcessExport->id,
        'status_id' => $statusProcessCompleted->id,
        'model_id' => $typeModelHotel->id,
    ]);

    $response->assertStatus(302)->assertRedirect(route('processes.index'));
})->with('admin');
