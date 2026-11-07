<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('email', 'admin@himatika.test')->first();
if ($user) {
    $user->password = \Illuminate\Support\Facades\Hash::make('password');
    $user->save();
    echo "Password berhasil di-reset menjadi: password\n";
} else {
    echo "User admin@himatika.test tidak ditemukan.\n";
}
