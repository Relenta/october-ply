<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Db;
use Illuminate\Support\Collection;
use RainLab\User\Facades\Auth;
use Rainlab\User\Models\User;
use Relenta\Ply\Models\Course;

class UserCourses extends ComponentBase {

    /**
     * A collection of courses to display
     *
     * @var Collection
     */
    public $courses;

    /**
     * Current user
     *
     * @var User
     */
    public $user;

    public function componentDetails()
    {
        return [
            'name'        => 'relenta.ply::lang.components.user_courses.name',
            'description' => 'relenta.ply::lang.components.user_courses.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'userID'            => [
                'title'             => 'relenta.ply::lang.properties.category_slug_title',
                'description'       => 'relenta.ply::lang.properties.category_slug_description',
                'type'              => 'string',
                'required'          => false,
                'validationMessage' => 'relenta.ply::lang.properties.category_slug_validation_message',
            ],
            'showSubscriptions' => [
                'title'       => 'relenta.ply::lang.properties.show_subscriptions_title',
                'description' => 'relenta.ply::lang.properties.show_subscriptions_description',
                'type'        => 'checkbox',
                'required'    => false,
            ],
        ];
    }

    public function onRun()
    {
        $this->getUser();

        if (! $this->user) {
            $this->setStatusCode(404);

            return $this->controller->run('404');
        }

        $this->courses = $this->page['courses'] = $this->getCourses();
    }

    /**
     * Returns the user ID from the URL
     *
     * @return string
     */
    public function userId()
    {
        $routeParameter = $this->property('userID');

        return $this->param($routeParameter);
    }

    /**
     * Returns the subscriptions checkbox from the URL
     *
     * @return string
     */
    public function showSubscriptions()
    {
        $this->page["showSubscriptions"] = $this->property('showSubscriptions');

        return $this->page["showSubscriptions"];
    }

    /**
     * Returns the collection of courses by user
     *
     * @return Collection
     */
    public function getCourses()
    {
        if ($this->showSubscriptions()) {
            $subscriptions = [];
            foreach ($this->user->course_subscriptions as $subscription) {
                $subscriptionData = [];
                $subscriptionData['data'] = $subscription;

                $currentUserId = Auth::getUser()->id;
                $userFlashcards = $subscription->cards()->whereHas('stats', function ($query) use ($currentUserId) {
                    $query->where('user_id', $currentUserId);
                })->get();

                $cardIds = (implode(',', $userFlashcards->pluck('id')->toArray()));

                if (! count($userFlashcards)) {
                    $subscriptionData['stats'] = 0;
                } else {
                    $queryDifficluty = Db::select("SELECT AVG(difficulty) AS avg_difficulty 
                            FROM relenta_ply_user_flashcard 
                            WHERE user_id = ? AND card_id IN ({$cardIds})", [
                        $currentUserId,
                    ]);

                    $knowledgeCoeff = 1 - $queryDifficluty[0]->avg_difficulty;

                    //dd($knowledgeCoeff);
                    $learnedCardsCoeff = 1 / ($subscription->cards()->count() / count($userFlashcards));

                    $subscriptionData['stats'] = round( 100 * $knowledgeCoeff * $learnedCardsCoeff);
                }

                $subscriptions[] = $subscriptionData;
            };

            return collect($subscriptions);
        }

        return Course::where('author_id', $this->user->id)->get();
    }

    public function getUser()
    {
        $user_id = $this->userId();

        if (! $user_id) {
            $this->user = $this->page['user'] = Auth::getUser();

            return;
        }

        $this->user = $this->page['user'] = User::where('id', $this->userId())->first();
    }
}
