<?php

namespace Relenta\Ply\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RainLab\User\Facades\Auth;
use Relenta\Ply\Classes\SpacedRepetition;
use Relenta\Ply\Models\UserFlashcard;

class FlashCards extends Controller
{

    /**
     * [repeat description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function repeat(Request $request)
    {
        // TODO: validate request
        $user   = Auth::getUser();

        $cardId = $request->input('card_id');
        $answer = $request->input('answer');

        $userCard          = UserFlashcard::firstOrCreate(['card_id' => $cardId, 'user_id' => $user->id]);
        $performanceRating = $this->getPerformanceRating($answer);
        $today             = $this->getDaysSinceEpoch();

        if (!$userCard->last_time) {
            $userCard->last_time = $today - 1;
        }
        if (!$userCard->interval) {
            $userCard->interval = 1;
        }

        $updatedCard = SpacedRepetition::repeat($userCard, $performanceRating, $today);

        return response()->json($updatedCard);
    }

/**
 * Return days count since UNIX epoch
 * @return int days count
 */
    private function getDaysSinceEpoch()
    {
        $DAY_IN_SECONDS = 24 * 60 * 60;

        return round(time() / $DAY_IN_SECONDS);
    }

    protected function getPerformanceRating($answer)
    {
        switch ($answer) {
            case 'yes':
                return 1;
            case 'no':
                return 0;
            case 'maybe':
                return 0.6;
            default:
                return 0.6;
        }
    }

}
