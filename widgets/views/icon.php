<?php
use panix\engine\Html;

echo Html::a(Html::icon('icon-compare'), 'javascript:compare.add(' . $this->context->pk . ');', $this->context->linkOptions);
