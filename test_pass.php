<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::all();
foreach ($users as $user) {
    echo "User: " . $user->email . " (ID: " . $user->id . ")\n";
    $hash = $user->getRawOriginal('password');
    echo "Check '123456': " . (Hash::check('123456', $hash) ? 'YES' : 'NO') . "\n";
    echo "Check '123123': " . (Hash::check('123123', $hash) ? 'YES' : 'NO') . "\n";
    echo "Check 'password': " . (Hash::check('password', $hash) ? 'YES' : 'NO') . "\n";
    echo "Check 'aldikurniawan': " . (Hash::check('aldikurniawan', $hash) ? 'YES' : 'NO') . "\n";
}
