<?php

namespace App\Listeners;

use App\Actions\CalculateLessonAchievementAction;
use App\Events\LessonWatched;

class ReturnLessonAchievement
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched $event): void
    {
        $lesson = $event->lesson;

        $user = $lesson->userLesson;


        if ($user) {
            $user->lessons()->save($lesson);

            app(CalculateLessonAchievementAction::class)->handle($user);
        } else {

            //lesson is null
        }
    }
}
