<?php

namespace Tests\Feature;

use App\Events\LessonWatched;
use App\Listeners\ReturnLessonAchievement;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LessonWatchedEventTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testLessonWatchedEventHandling()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create(['title' => 'lesson']);
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
        $badgeAchievements = [
            ['Beginner', 0],
            ['Intermediate', 4],
            ['Advanced', 8],
            ['Master', 10],
        ];
        foreach ($badgeAchievements as [$name, $requirement]) {
            Badge::factory()->create([
                'name' => $name,
                'requirement' => $requirement,
            ]);
        }
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

        // Fake the event to prevent actual broadcasting
        Event::fake();

        // Fire the CommentWritten event
        event(new LessonWatched($lesson, $user));

        // Check if the ReturnCommentAchievement listener handles the event
        $listener = new ReturnLessonAchievement();
        $listener->handle(new LessonWatched($lesson, $user)); // Simulate the event handling

        // Add your assertions here to check if the listener's actions were successful
        $this->assertTrue(true); // Replace with your actual assertions
    }
}
