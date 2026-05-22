<?php
namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
    public function run() {
        // Cek apakah role sudah ada sebelum menambah
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'color' => 'danger']);
        }
        if (!Role::where('name', 'bendahara')->exists()) {
            Role::create(['name' => 'bendahara', 'display_name' => 'Bendahara', 'color' => 'warning']);
        }
        if (!Role::where('name', 'warga')->exists()) {
            Role::create(['name' => 'warga', 'display_name' => 'Warga', 'color' => 'primary']);
        }
        if (!Role::where('name', 'ketua')->exists()) {
            Role::create(['name' => 'ketua', 'display_name' => 'Ketua RT', 'color' => 'success']);
        }
        if (!Role::where('name', 'sekretaris')->exists()) {
            Role::create(['name' => 'sekretaris', 'display_name' => 'Sekretaris', 'color' => 'info']);
        }
    }
}
