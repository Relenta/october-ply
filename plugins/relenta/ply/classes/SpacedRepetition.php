<?php namespace Relenta\Ply\Classes;

use DateTime;

/** Implementation of SM2 */
class SpacedRepetition {

    /**
     * Calculates variable, which uses to sort cards descending by this.
     *
     * @param string    $dateLastReviewed   Date, card was reviewed last time.
     * @param float     $daysBetweenReviews How many days should occur between review attempts for this item.
     * @param float     $performanceRating  Indicator of the correct answer.
     *
     * @return float
     * */
    public static function calcPercentOverdue ($dateLastReviewed, $daysBetweenReviews, $performanceRating) {
        if (static::isCorrect($performanceRating)) {
            $now = new DateTime();

            if (!$dateLastReviewed) {
                $diffDays = 0;
            }
            else {
                $dateLastReviewed   = new DateTime($dateLastReviewed);
                $diffDays           = $now->diff($dateLastReviewed)->days;
            }

            return min(2, $diffDays / $daysBetweenReviews);
        }

        return 1;
    }

    /**
     * @param float $oldDifficulty      Indicator, how difficult card is.
     * @param float $percentOverdue     Variable, which uses to sort cards descending by this.
     * @param float $performanceRating  Indicator of the correct answer.
     *
     * @return float
     */
    public static function calcDifficulty ($oldDifficulty, $percentOverdue, $performanceRating) {
        $difficulty = $oldDifficulty + $percentOverdue * 1/17 * (8 - 9 * $performanceRating);

        return static::clamp($difficulty);
    }

    /** */
    public static function calcDifficultyWeight ($difficulty) {
        return 3 - 1.7 * $difficulty;
    }

    /** */
    public static function calcDaysBetweenReviews ($oldDaysBetweenReviews, $percentOverdue, $difficultyWeight, $performanceRating) {
        if (static::isCorrect($performanceRating)) {
            return $oldDaysBetweenReviews * (1 + ($difficultyWeight - 1) * $percentOverdue);
        }

        return min(1, $oldDaysBetweenReviews * (1 / pow($difficultyWeight, 2)));
    }

    /** */
    private static function isCorrect($performanceRating) {
        if ($performanceRating > 0.6) {
            return true;
        }
        return false;
    }

    /** */
    private static function clamp($value, $minValue = 0, $maxValue = 1) {
        return max($minValue, min($maxValue, $value));
    }
}