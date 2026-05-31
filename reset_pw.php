<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'boudoumifella@gmail.com')->first();
if ($user) {
    $user->password = Illuminate\Support\Facades\Hash::make('password');
    $user->save();
    echo "SUCCESS: Admin password updated to 'password'.\n";
} else {
    echo "ERROR: Admin user not found.\n";
}
