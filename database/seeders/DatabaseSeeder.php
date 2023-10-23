<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        $comments = Comment::factory()
            ->count(20)
            ->create();



         // create seeders for lessons
        $lessonAchievements = [
            ['First Lesson Watched', 1],
            ['5 Lessons Watched', 5],
            ['10 Lessons Watched', 10],
            ['25 Lessons Watched', 25],
            ['50 Lessons Watched', 50],
        ];

        $commentAchievements = [
            ['First Comment Written', 1],
            ['3 Comments Written', 3],
            ['5 Comments Written', 5],
            ['10 Comments Written', 10],
            ['20 Comments Written', 20],
        ];



        foreach ($lessonAchievements as [$name, $requirement]) {
            Achievement::factory()->create([
                'name' => $name,
                'requirement' => $requirement,
                'type' => 'lesson'
            ]);
        }

        foreach ($commentAchievements as [$name, $requirement]) {
            Achievement::factory()->create([
                'name' => $name,
                'requirement' => $requirement,
                'type'=> 'comment'
            ]);
        }

    }

}
