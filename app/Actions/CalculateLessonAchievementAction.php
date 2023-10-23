<?php

namespace App\Actions;

use App\Events\AchievementUnlockedEvent;
use App\Events\BadgeUnlockedEvent;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\LessonUser;
use App\Models\User;
use App\Models\UserAchievements;
use App\Models\UserBadge;

class CalculateLessonAchievementAction
{

    public function handle(User $user)
    {
        $userLessons = LessonUser::where('user_id',$user->id)
            ->where('watched',1)->get();
        $userAchievements = UserAchievements::where('user_id',$user->id)->get();

        Achievement::where('type','comment')
            ->each(function (Achievement $achievement) use ($user, $userLessons){


                if($userLessons->count() === $achievement->requirement) {
                    $lessonsIdsThatLedToAchievement = $userLessons->pluck('id');
                    $achievementRecord = [
                        'name' => $achievement->name,
                        'user_id' => $user->id,
                        'achievement_id' => $achievement->id,
                        'metadata' => $lessonsIdsThatLedToAchievement,
                        'type' => 'comment',
                    ];

                    UserAchievements::create($achievementRecord);

                    // trigger event for comment achievement here
                    event(new AchievementUnlockedEvent($achievement->name,$user));
                }

            });


        Badge::get()->each(function (Badge $badge) use ($user, $userAchievements){
            // Check if the user achievements contain the required number
            if ($userAchievements->count() === $badge->requirement) {
                // Check if a UserBadge record with the same badge_id and user_id doesn't already exist
                if (!UserBadge::where('badge_id', $badge->id)
                    ->where('user_id', $user->id)
                    ->exists()) {
                    // You can proceed to create a UserBadge record here.
                    $achievementIdsThatLedToBadge = $userAchievements->pluck('id');
                    $badgeRecord = [
                        'badge_id' => $badge->id,
                        'user_id' => $user->id,
                        'metadata' => $achievementIdsThatLedToBadge,
                    ];

                    UserBadge::create($badgeRecord);

                    // Trigger an event for badge achievement
                    event(new BadgeUnlockedEvent($badge->name, $user));
                }
            }
        });



    }
}
