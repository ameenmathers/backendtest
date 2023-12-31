<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LessonWatched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Lesson $lesson;
    public User $user;

    /**
     * Create a new event instance.
     */

    public function __construct(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
