<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userExist = User::query()->where('email', 'rejman@admin.com')->first();

        if (! $userExist) {
            User::query()->create([
                'name' => 'Rejman Nascimento',
                'email' => 'rejman@admin.com',
                'password' => Hash::make(12345678)
            ]);
        }

        User::factory()->count(50)->create();
    }
}
