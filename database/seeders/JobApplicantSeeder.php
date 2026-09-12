<?php

namespace Database\Seeders;

use App\Models\JobApplicant;
use Illuminate\Database\Seeder;

class JobApplicantSeeder extends Seeder
{
    public function run(): void
    {
        $applicants = [
            ['name' => 'Sarah Al-Rashidi', 'email' => 'sarah.rashidi@example.com', 'phone' => '+971 50 123 4567', 'position' => 'Structural Engineer', 'status' => 'interview'],
            ['name' => 'Omar Farouk', 'email' => 'omar.farouk@example.com', 'phone' => '+20 100 555 2211', 'position' => 'Site Supervisor', 'status' => 'reviewing'],
            ['name' => 'Lina Haddad', 'email' => 'lina.haddad@example.com', 'phone' => '+966 55 987 6543', 'position' => 'Interior Designer', 'status' => 'new'],
        ];

        foreach ($applicants as $applicant) {
            JobApplicant::updateOrCreate(
                ['email' => $applicant['email']],
                $applicant + ['cv_path' => null]
            );
        }
    }
}