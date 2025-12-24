<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$user = App\Models\User::first();

if ($user) {
    echo "Found User:\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Status: " . ($user->status ? 'True' : 'False') . "\n";
    // verify 'password'
    // echo "Password Hash: " . $user->password . "\n";
} else {
    echo "No users found.\n";
}
