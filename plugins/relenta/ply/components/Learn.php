<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use October\Rain\Exception\SystemException;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\CardSide;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Unit;

class Learn extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'          => 'relenta.ply::lang.components.learn.name',
            'description'   => 'relenta.ply::lang.components.learn.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * Returns not-found page with 404 status code
     * @return Response
     */
    public function callNotFoundPage() {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }

}