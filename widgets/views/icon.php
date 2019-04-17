<?php
use panix\engine\Html;

echo Html::a(Html::icon('compare'), ['/compare/default/add/','id'=>$this->context->pk], $this->context->linkOptions);
