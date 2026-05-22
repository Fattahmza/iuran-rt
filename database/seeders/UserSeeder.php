<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run() {
        // Admin
        if (!User::where('email', 'admin@iurandesaku.com')->exists()) {
            User::create([
                'name' => 'Admin Desa',
                'email' => 'admin@iurandesaku.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]);
        }
        // Bendahara
        if (!User::where('email', 'bendahara@iurandesaku.com')->exists()) {
            User::create([
                'name' => 'Bendahara Desa',
                'email' => 'bendahara@iurandesaku.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ]);
        }
        // Warga contoh
        if (!User::where('email', 'warga1@iurandesaku.com')->exists()) {
            User::create([
                'name' => 'Warga 1',
                'email' => 'warga1@iurandesaku.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
            ]);
        }
    }
}
