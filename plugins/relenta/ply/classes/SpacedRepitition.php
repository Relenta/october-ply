<?php namespace Relenta\Ply\Classes;

use DateTime;

/** Implementation of SM2 */
class SpacedRepitition {

    public static function calcPercentOverdue ($dateLastReviewed, $daysBetweenReviews, $performanceRating) {
        if (static::isCorrect($performanceRating)) {
            $now                = new DateTime();
            $dateLastReviewed   = new DateTime($dateLastReviewed);
            $diff               = $now->diff($dateLastReviewed);

            return min(2, $diff->days / $daysBetweenReviews);
        }

        return 1;
    }

    public static function calcDifficulty ($oldDifficulty, $percentOverdue, $performanceRating) {
        $difficulty = $oldDifficulty + $percentOverdue * 1/17 * (8 - 9 * $performanceRating);

        return static::clamp($difficulty);
    }

    public static function calcDifficultyWeight ($difficulty) {
        return 3 - 1.7 * $difficulty;
    }

    public static function calcDaysBetweenReviews ($oldDaysBetweenReviews, $percentOverdue, $difficultyWeight, $performanceRating) {
        if (static::isCorrect($performanceRating)) {
            return $oldDaysBetweenReviews * (1 + ($difficultyWeight - 1) * $percentOverdue);
        }

        if ($oldDaysBetweenReviews == 0) {
            return 0;
        }

        return $oldDaysBetweenReviews * (1 / pow($difficultyWeight, 2));
    }

    private static function isCorrect($performanceRating) {
        if ($performanceRating > 0.6) {
            return true;
        }
        return false;
    }

    private static function clamp($value, $minValue = 0, $maxValue = 1) {
        return max($minValue, min($maxValue, $value));
    }
}