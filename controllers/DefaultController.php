<?php

namespace panix\mod\compare\controllers;

use panix\engine\controllers\WebController;
use panix\mod\compare\components\CompareProducts;
use panix\engine\CMS;
class DefaultController extends WebController {

    /**
     * @var CompareProducts
     */
    public $model;

    public function beforeAction($action) {
        $this->model = new CompareProducts;
        return true;
    }

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * Render index view
     */
    public function actionIndex($catId = false) {

        $this->pageTitle = Yii::t('compare/default', 'Сравнение продуктов');
        $this->pageName = Yii::t('compare/default', 'MODULE_NAME');


        $this->breadcrumbs = array($this->pageName);
        $compareForm = new CompareForm;
        if (isset($_POST['CompareForm']))
            $compareForm->attributes = $_POST['CompareForm'];

        if (!$catId && isset($this->model->products)) {
            foreach ($this->model->products as $id => $group) {
                $catId = $id;
                break;
            }
        }


        return $this->render(CMS::isModile() ? 'mobile_index' : 'index', array('compareForm' => $compareForm, 'catId' => $catId));
    }

    /**
     * Add product to compare list
     * @param $id ShopProduct id
     */
    public function actionAdd($id) {
        $this->model->add($id);
        $message = Yii::t('compare/default', 'Продукт успешно добавлен в список сравнения.');
        $this->addFlashMessage($message);
        if (!Yii::$app->request->isAjax) {
            $this->redirect($this->createUrl('index'));
        } else {
            echo Json::encode(array(
                'message' => $message,
                'btn_message' => Yii::t('compare/default', 'BTN_COMPARE'),
                'count' => $this->model->count()
            ));
        }
    }

    /**
     * Remove product from list
     * @param string $id product id
     */
    public function actionRemove($id) {
        $this->model->remove($id);
        if (!Yii::$app->request->isAjax)
            return $this->redirect($this->createUrl('index'));
    }

}
