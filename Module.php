<?php

namespace panix\mod\compare;

use panix\engine\WebModule;

class Module extends WebModule
{

    public $routes = [
        'compare' => 'compare/default/index',
        'compare/catId/<catId>' => 'compare/default/index',
        'compare/add/<id>' => 'compare/default/add',
        'compare/remove/<id>' => 'compare/default/remove',
    ];

}
