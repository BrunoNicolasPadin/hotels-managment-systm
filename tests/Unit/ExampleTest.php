<?php

it('should return ok', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});