<?php

namespace Relenta\Ply\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RainLab\User\Facades\Auth;
use Relenta\Ply\Models\UserFlashcard;
use Relenta\Ply\Classes\SpacedRepetition;

class FlashCards extends Controller
{

    public function repeat(Request $request)
    {
        // TODO: validate request
        
        $user   = Auth::getUser();
        $cardId = $request->get('card');

        $answer = $request->get('answer');
        $performanceRating = $this->getPerformanceRating($answer);

        $userCard = UserFlashcard::firstOrCreate(['card_id' => $cardId, 'user_id' => $user->id]);

        $percentOverdue = SpacedRepetition::calcPercentOverdue(
            $userCard->last_time,
            $userCard->days_between_reviews,
            $performanceRating
        );

        $userCard->difficulty = SpacedRepetition::calcDifficulty(
            $userCard->difficulty,
            $percentOverdue,
            $performanceRating
        );

        $difficultyWeight = SpacedRepetition::calcDifficultyWeight(
            $userCard->difficulty
        );

        $userCard->days_between_reviews = SpacedRepetition::calcDaysBetweenReviews(
            $userCard->days_between_reviews,
            $percentOverdue, 
            $difficultyWeight, 
            $performanceRating
        );

        $userCard->save();
        dd($userCard);
    }

    protected function getPerformanceRating($answer) {
        switch($answer) {
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
