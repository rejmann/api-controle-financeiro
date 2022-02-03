<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Rejman Nascimento',
            'email' => 'rejman@admin.com',
            'password' => Hash::make(12345678)
        ]);

        User::factory()->count(50)->create();
    }
}
