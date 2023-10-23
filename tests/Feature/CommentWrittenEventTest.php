<?php

use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Events\CommentWritten;
use App\Listeners\ReturnCommentAchievement;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Event;

class CommentWrittenEventTest extends TestCase
{
    use RefreshDatabase;

    public function testCommentWrittenEventHandling()
    {
        // Create a user and a comment
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id, 'body' => 'loremm upsem',]);
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
        event(new CommentWritten($comment));

        // Check if the ReturnCommentAchievement listener handles the event
        $listener = new ReturnCommentAchievement();
        $listener->handle(new CommentWritten($comment)); // Simulate the event handling

        // Add your assertions here to check if the listener's actions were successful
        $this->assertTrue(true); // Replace with your actual assertions
    }
}
