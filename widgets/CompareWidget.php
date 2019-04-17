<?php

namespace panix\mod\compare\widgets;

use panix\mod\compare\assets\CompareAsset;
use Yii;
use panix\engine\data\Widget;
use panix\mod\compare\components\CompareProducts;
use yii\base\InvalidArgumentException;

/**
 * Widget add to compare module for shop.
 *
 * @version 1.0
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Example:
 * <code>
 * echo \panix\mod\compare\widgets\CompareWidget::widget([
 *  'pk' => $model->primaryKey,
 *  'skin' => 'icon',
 *  'linkOptions' => ['class' => 'btn btn-compare']
 * ]);
 * </code>
 *
 */
class CompareWidget extends Widget
{

    public $pk;
    public $linkOptions = [];
    public $isAdded = false;

    public function init()
    {
        if (is_null($this->pk))
            throw new InvalidArgumentException(Yii::t('default', 'ERROR_PK_ISNULL'));

        CompareAsset::register($this->view);
        parent::init();
    }

    public function run()
    {
        $compareComponent = new CompareProducts();
        $this->isAdded = (in_array($this->pk, $compareComponent->getIds())) ? true : false;


        if($this->isAdded){
            $this->linkOptions['title']=Yii::t('compare/default','ALREADY_EXIST');
            $this->linkOptions['class'] .= ' added';
        }

        return $this->render($this->skin, []);
    }

}
