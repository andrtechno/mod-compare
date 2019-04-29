<?php

namespace panix\mod\compare;

use panix\engine\web\AssetBundle;

class CompareAsset extends AssetBundle {

    public $sourcePath = __DIR__.'/assets';

    public $js = [
        'js/compare.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
