<?php namespace Relenta\Ply;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            '\Relenta\Ply\Components\Categories' => 'categories',
            '\Relenta\Ply\Components\Courses' => 'courses',
            '\Relenta\Ply\Components\Units' => 'units',
            '\Relenta\Ply\Components\Cards' => 'cards',
        ];
    }

    public function registerSettings()
    {
    }

    public function pluginDetails()
    {
        return [
            'name' => 'Ply',
            'description' => '',
            'author' => 'Relenta',
            'icon' => 'icon-leaf'
        ];
    }
}
