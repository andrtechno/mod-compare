<?php

namespace panix\mod\compare;

use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                'compare/<cat_id:\d+>' => 'compare/default/index',
                'compare' => 'compare/default/index',

                'compare/add/<id:\d+>' => 'compare/default/add',
                'compare/remove/<id:\d+>' => 'compare/default/remove',
            ],
            true
        );
    }


}
