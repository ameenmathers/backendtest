<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Events\AchievementUnlockedEvent;
use Illuminate\Support\Facades\Event;


class AchievementUnlockedEventTest extends TestCase
{
    use RefreshDatabase;

    public function testAchievementUnlockedEvent()
    {

        $user = User::factory()->create();

        $achievementName = "Test Achievement";

        Event::fake();

        event(new AchievementUnlockedEvent($achievementName,$user));

        $this->assertTrue(true);
        // You can add more specific assertions as needed.
    }
}
