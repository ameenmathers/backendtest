<?php

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserAchievements;
use App\Models\UserBadge;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {

        $unlocked_achievements = UserAchievements::where('user_id',$user->id)->pluck('name');
        $number_of_achievements = UserAchievements::where('user_id',$user->id)->count();

        $user_achievements_ids = UserAchievements::where('user_id',$user->id)->pluck('achievement_id');
        $next_available_achievements = Achievement::whereNotIn('id',$user_achievements_ids)->pluck('name');

        $user_badges = UserBadge::where('user_id',$user->id)->first();
        if ($user_badges) {
            $current_badge = Badge::where('id', $user_badges->badge_id)->pluck('name');
            $next_badge_id = $user_badges->badge_id + 1;
            $next_badge = Badge::where('id',$next_badge_id)->pluck('name');

            $get_badge = Badge::find($next_badge_id);
            $get_badge_requirements = $get_badge->requirement;
            $remaining_to_unlock_next_badge = $get_badge_requirements - $number_of_achievements;
        } else {
            // Handle the case when no user badge is found.
            $current_badge = 'Beginner';
            $next_badge = 'Intermediate';
            $remaining_to_unlock_next_badge = 4;
        }




        return response()->json([
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaining_to_unlock_next_badge' => $remaining_to_unlock_next_badge
        ]);
    }


}
