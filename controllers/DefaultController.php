<?php

namespace panix\mod\compare\controllers;


use panix\mod\compare\forms\CompareForm;
use Yii;
use panix\engine\controllers\WebController;
use panix\mod\compare\components\CompareProducts;
use panix\engine\CMS;
use yii\web\Response;

class DefaultController extends WebController
{

    /**
     * @var CompareProducts
     */
    public $model;

    /**
     * @var array
     */
    protected $attributes = [];

    public function beforeAction($action)
    {
        $this->model = new CompareProducts;
        return true;
    }

    /**
     * Render index view
     * @param bool|int $cat_id
     * @return string
     */
    public function actionIndex($cat_id = false)
    {
        $this->pageName = Yii::t('compare/default', 'MODULE_NAME');


        $this->breadcrumbs[] = $this->pageName;
        $compareForm = new CompareForm();
        if (isset($_POST['CompareForm']))
            $compareForm->attributes = $_POST['CompareForm'];

        if (!$cat_id && isset($this->model->products)) {
           // foreach ($this->model->products as $id => $group) {
               // $cat_id = $id;
              //  break;
           // }
        }


        return $this->render(CMS::isModile() ? 'mobile_index' : 'index', [
            'compareForm' => $compareForm,
            'cat_id' => $cat_id
        ]);
    }

    /**
     * Add product to compare list
     * @param $id \panix\mod\shop\models\Product Product id
     * @return Response
     */
    public function actionAdd($id)
    {
        $this->model->add($id);
        $message = Yii::t('compare/default', 'Продукт успешно добавлен в список сравнения.');
        //$this->addFlashMessage($message);
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->data = [
                'message' => $message,
                'btn_message' => Yii::t('compare/default', 'BTN_COMPARE'),
                'count' => $this->model->count(),
                'title'=>Yii::t('compare/default','ALREADY_EXIST')
            ];
        }
    }

    /**
     * Remove product from list
     * @param int $id product id
     * @return Response
     */
    public function actionRemove($id)
    {
        $this->model->remove($id);
        if (!Yii::$app->request->isAjax)
            return $this->redirect(['index']);
    }

}
