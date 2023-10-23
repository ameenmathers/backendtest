<?php

namespace App\Listeners;

use App\Actions\CalculateCommentAchievementAction;
use App\Events\CommentWritten;

class ReturnCommentAchievement
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
     * @throws \Exception
     */
    public function handle(CommentWritten $event): void
    {
        $comment = $event->comment;
        $user = $comment->user;


        $user->comments()->save($comment);

        app(CalculateCommentAchievementAction::class)->handle($user);
    }
}
