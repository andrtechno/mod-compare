<?php



echo Html::link(Html::tag('i',array('class'=>'icon-compare'),'',true), 'javascript:compare.add(' . $this->pk . ');', $this->linkOptions);
