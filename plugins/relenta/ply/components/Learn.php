<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;

class Learn extends ComponentBase {

    public function onRun()
    {
        $this->page['mode'] = request()->get('mode', 1);
    }

    public function componentDetails()
    {
        return [
            'name'        => 'relenta.ply::lang.components.learn.name',
            'description' => 'relenta.ply::lang.components.learn.description'
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
    public function callNotFoundPage()
    {
        $this->setStatusCode(404);

        return $this->controller->run('404');
    }

}
