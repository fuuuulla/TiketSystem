<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::firstOrCreate(
    ['email' => 'boudoumifella@gmail.com'],
    [
        'name' => 'Admin Fella',
        'password' => Illuminate\Support\Facades\Hash::make('password'),
    ]
);

$user->is_admin = true;
// Also verify if password was already set but needs reset
$user->password = Illuminate\Support\Facades\Hash::make('password');
$user->save();

echo "SUCCESS: Admin user 'boudoumifella@gmail.com' created/updated with password 'password'.\n";
