<?php

use App\Models\User;

dataset('admin', [
    fn () => User::where('email', 'admin@gmail.com')->first(),
]);
