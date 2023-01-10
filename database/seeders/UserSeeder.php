<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function run(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'rejman@admin.com']);

        if (! $user) {
            $this->userRepository->create([
                'name' => 'Rejman Nascimento',
                'email' => 'rejman@admin.com',
                'password' => Hash::make(12345678)
            ]);
        }

        User::factory()->count(50)->create();
    }
}
