<?php

namespace panix\mod\compare\widgets;

use panix\mod\compare\widgets\assets\CompareAsset;
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

        $linkOptions = [];
        $class = ($this->isAdded) ? 'added' : '';
        $textType = ($this->isAdded) ? 1 : 0;
        $linkOptions['class'] = '';

        if (isset($this->linkOptions['class'])) {
            $linkOptions['class'] .= (isset($this->linkOptions['class'])) ? $this->linkOptions['class'] : '';
        }

        $linkOptions['id'] = 'compare-' . $this->pk;
        $linkOptions['class'] .= ' ' . $class;
        $this->linkOptions = $linkOptions;


        return $this->render($this->skin, []);
    }

}
