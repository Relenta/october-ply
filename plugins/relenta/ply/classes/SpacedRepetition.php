<?php namespace Relenta\Ply\Classes;

/**
 * Implementation of SM2+ algorithm
 */
class SpacedRepetition
{

    const WORST  = 0;
    const NORMAL = 0.6;
    const BEST   = 1;

    /**
     * Repeat the card and update statistics
     * 
     * @param  UserFlashcard $userCard          card instance
     * @param  float $performanceRating         performance rating
     * @param  int $today                       days from Unix epoch
     * @return boolean                          update status
     */
    public static function repeat($userCard, $performanceRating, $today)
    {
        $percentOverdue = static::calcPercentOverdue($userCard, $today);

        $difficulty = static::clamp( 
            $userCard->difficulty + (8 - 9 * $performanceRating) * $percentOverdue / 17,
            0, 1
        );

        $difficultyWeight = 3 - 1.7 * $difficulty;

        if ($performanceRating === static::WORST) {
            $tempInterval = round(1 / $difficultyWeight / $difficultyWeight);

            $interval = ($tempInterval > 0) ? $tempInterval : 1;
        } else {
            $interval = 1 + round(($difficultyWeight - 1) * $percentOverdue);
        }

        $userCard->update([
            'interval' => $interval,
            'difficulty'           => $difficulty,
            'last_time'            => $today,
            'next_time'            => $today + $interval,
        ]);

        return $userCard;
    }

    /**
     * Calculate percent overdue
     * 
     * @param  UserFlashcard $userCard   instance to repeat
     * @param  int $today                days since Unix epoch
     * @return float                     overdue percent
     */
    public static function calcPercentOverdue($userCard, $today)
    {
        // dd($userCard->toArray());
        $calculated = ($today - $userCard->last_time) / $userCard->interval;

        return ($calculated > 2) ? 2 : $calculated;
    }

    /**
     * Clamp value to interval
     * 
     * @param  float  $value      number to clump
     * @param  integer $minValue  lower border
     * @param  integer $maxValue  upper border
     * @return float              number from given interval
     */
    private static function clamp($value, $minValue = 0, $maxValue = 1)
    {
        return max($minValue, min($maxValue, $value));
    }
}
