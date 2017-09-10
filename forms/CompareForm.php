<?php
namespace panix\mod\compare\forms;

class CompareForm extends \yii\base\Model {


    public $type=0;

    const MODULE_ID = 'compare';
   /* public function init() {
        $this->attributes = array(
            'type'=>(int)Yii::app()->request->getParam('type',$this->type)
        );
    }*/
    public function rules() {
        return [
            ['type', 'required'],
        ];
    }

}
