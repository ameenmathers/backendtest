<?php

namespace Tests\Feature;

use App\Events\BadgeUnlockedEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BadgeUnlockedEventTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function testBadgeUnlockedEvent()
    {
        $user = User::factory()->create();

        $badgeName = "Test Badge";

        Event::fake();

        event(new BadgeUnlockedEvent($badgeName, $user));

        $this->assertTrue(true);
    }
}
