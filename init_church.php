<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Church;
use App\Models\ChurchDetail;
use App\Models\User;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

echo "Checking database initialization...\n";

// Run seeders if countries table is empty
if (\Illuminate\Support\Facades\DB::table('countries')->count() === 0) {
    echo "Running DatabaseSeeder...\n";
    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
    echo Artisan::output();
}

$church = Church::first();

if (!$church) {
    echo "Creating Church...\n";
    $church = Church::create([
        'name' => 'Synagogue',
        'address' => 'Main Street',
        'pincode' => '10001',
        'slug' => 'synagogue',
        'status' => 1,
    ]);
}

// Ensure church_details has login_status = 1
$metaKeys = [
    'login_status' => '1',
    'maintenance' => '0',
    'site_title' => 'Synagogue',
    'church_full_name' => 'Synagogue',
    'church_short_name' => 'Synagogue',
    'member_web_login' => '1',
    'guest_login' => '1',
];

foreach ($metaKeys as $k => $v) {
    ChurchDetail::updateOrCreate(
        ['church_id' => $church->id, 'meta_key' => $k],
        ['meta_value' => $v]
    );
}

// Ensure Admin user exists
$adminUser = User::where('email', 'admin@synagogue.com')->first();
if (!$adminUser) {
    echo "Creating Admin user...\n";
    $adminUser = User::create([
        'name' => 'Lahiru Thikshana',
        'email' => 'admin@synagogue.com',
        'password' => Hash::make('admin123456'),
        'mobile_no' => '1234567890',
        'church_id' => $church->id,
        'usergroup_id' => 3, // ChurchAdmin
        'email_verified' => 1,
    ]);

    Userprofile::create([
        'user_id' => $adminUser->id,
        'church_id' => $church->id,
        'firstname' => 'Lahiru',
        'lastname' => 'Thikshana',
        'profession' => 'admin',
        'status' => 'active',
        'membership_type' => 'member',
        'membership_start_date' => now()->toDateString(),
    ]);
}

echo "Database initialization complete! Church ID: {$church->id}\n";
