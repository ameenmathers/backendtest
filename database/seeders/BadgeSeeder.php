<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            ['Beginner', 0],
            ['Intermediate', 4],
            ['Advanced', 8],
            ['Master', 10],
        ];

        foreach ($badges as [$name, $requirement]) {
            Badge::factory()->create([
                'name' => $name,
                'requirement' => $requirement,
            ]);
        }
    }
}
