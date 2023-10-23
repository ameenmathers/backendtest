<?php

namespace App\Providers;

use App\Events\Comment;
use App\Events\CommentWritten;
use App\Events\Lesson;
use App\Events\LessonWatched;
use App\Listeners\ReturnCommentAchievement;
use App\Listeners\ReturnLessonAchievement;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LessonWatched::class => [
            ReturnLessonAchievement::class,
        ],
        CommentWritten::class => [
            ReturnCommentAchievement::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
