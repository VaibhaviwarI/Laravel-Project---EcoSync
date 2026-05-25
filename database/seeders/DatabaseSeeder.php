<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SanitationReport;
use App\Models\RecyclingRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Admin Manager',
            'email' => 'admin@ecosync.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'points' => 0,
        ]);

        // 2. Create Student User
        $student = User::create([
            'name' => 'Sarah Connor',
            'email' => 'sarah@ecosync.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'points' => 115, // 15 + 100 points from past collections
        ]);

        // 3. Sanitation Reports
        SanitationReport::create([
            'user_id' => $student->id,
            'category' => 'Overflowing Bin',
            'location' => 'Block A Dining Hall Entrance',
            'description' => 'Garbage bin is completely full and spilling organic waste onto the floor. Bad odor is spreading.',
            'priority' => 'high',
            'status' => 'pending',
        ]);

        SanitationReport::create([
            'user_id' => $student->id,
            'category' => 'Hazardous Waste',
            'location' => 'Chemistry Lab Room 104',
            'description' => 'Broken glass and chemical residue on laboratory counter table. Needs safe clearing.',
            'priority' => 'high',
            'status' => 'in_progress',
            'assigned_staff' => 'John Green',
        ]);

        SanitationReport::create([
            'user_id' => $student->id,
            'category' => 'General Garbage',
            'location' => 'Campus Library Back Gate Benches',
            'description' => 'A pile of plastic cups and snack cardboard boxes left on benches after a group study.',
            'priority' => 'low',
            'status' => 'resolved',
            'assigned_staff' => 'Dave Miller',
            'resolved_at' => now()->subDay(),
        ]);

        // 4. Recycling Requests
        RecyclingRequest::create([
            'user_id' => $student->id,
            'material_type' => 'Plastic Bottles / Containers',
            'estimated_weight' => 3.20,
            'status' => 'pending',
            'points_awarded' => 0,
        ]);

        RecyclingRequest::create([
            'user_id' => $student->id,
            'material_type' => 'Electronic Waste (E-Waste)',
            'estimated_weight' => 1.50,
            'status' => 'collected',
            'points_awarded' => 15,
        ]);

        RecyclingRequest::create([
            'user_id' => $student->id,
            'material_type' => 'Paper & Cardboard',
            'estimated_weight' => 10.00,
            'status' => 'collected',
            'points_awarded' => 100,
        ]);
    }
}
