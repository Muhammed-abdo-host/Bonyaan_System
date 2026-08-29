<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $adminRole = Role::where('name', 'admin')->first();
        $clientRole = Role::where('name', 'client')->first();

        User::firstOrCreate(
            ['email' => 'admin@bonyaan.test'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'phone' => '01000000000',
            ]);


            User::firstOrCreate(
            ['email' => 'client@bonyaan.test'],
            [
                'role_id' => $clientRole->id,
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'phone' => '01000000001',
            ]
        );
    }
}
