<?php

namespace panix\mod\compare\components;

use Yii;
use panix\mod\shop\models\Product;
use panix\mod\shop\models\Attribute;
use yii\base\BaseObject;
use yii\helpers\VarDumper;

class CompareProducts extends BaseObject
{

    /**
     * Max products to compare
     */
    const MAX_PRODUCTS = 20;

    /**
     * @var string
     */
    public $sessionKey = 'CompareProducts';

    /**
     * @var \panix\engine\web\DbSession
     */
    public $session;

    /**
     * @var array
     */
    private $_products;

    /**
     * @var array
     */
    private $_attributes;

    /**
     * Initialize component
     */
    public function __construct()
    {
        $this->session = Yii::$app->session;

        if (!isset($this->session[$this->sessionKey]) || !is_array($this->session[$this->sessionKey]))
            $this->session[$this->sessionKey] = [];
        parent::__construct();
    }

    /**
     * Check if product exists add to list
     * @param int $id product id
     * @return bool
     */
    public function add($id)
    {
        if ($this->count() <= self::MAX_PRODUCTS && Product::find()->published()->where(['id' => $id])->count() > 0) {
            $current = $this->getIds();
            $current[(int)$id] = (int)$id;
            $this->setIds($current);
            return true;
        }
        return false;
    }

    /**
     * Remove product from list
     * @param $id
     */
    public function remove($id)
    {
        $current = $this->getIds();
        if (isset($current[$id]))
            unset($current[$id]);
        $this->setIds($current);
    }

    /**
     * @return array of product id added to compare
     */
    public function getIds()
    {
        return $this->session[$this->sessionKey];
    }

    /**
     * @param array $ids
     */
    public function setIds(array $ids)
    {
        $this->session[$this->sessionKey] = array_unique($ids);
    }

    /**
     * Clear compare list
     */
    public function clear()
    {
        $this->setIds([]);
    }

    /**
     * @return array of /panix/mod/shop/models/Product models to compare
     */
    public function getProducts()
    {

        if ($this->_products === null){
            $this->_products = Product::find()
                ->where(['id' => array_values($this->getIds())])
                ->all();
        }

        $result = [];

        foreach ($this->_products as $state) {
            Yii::debug('getProducts');
            $cid = $state->mainCategory->id;
            // Create the sub-array if it doesn't exist
           // if (!isset($result[$cid])) {
           //     $result[$cid]['items'] = [];
           //     $result[$cid]['name'] = $state->mainCategory->name;
           // }

            // Then append the state onto it
            $result[$cid]['items'][] = $state;
            $result[$cid]['name'] = $state->mainCategory->name;


            $result[$cid]['attributes'] = [];

            $names = [];
            $names = array_merge($names, array_keys($state->getEavAttributes()));

            if (isset($result[$cid]['attributes'])) {

                $query = Attribute::find()
                    ->where(['in', 'name', $names])
                    ->displayOnFront()
                    ->useInCompare()
                  //  ->asArray()
                    ->all();

                if ($query) {

                    foreach ($query as $m) {
                        //$result[$cid]['attributes'][$m['name']] = $m;
                        $result[$cid]['attributes'][$m->name] = $m;
                       // $result[$cid]['attributes']['test'] = $m;
                    }
                }
            }

        }
      //  echo VarDumper::dump($result,3,true);die;
        return $result;
    }

    /**
     * Count products to compare
     * @return int
     */
    public function count()
    {
        return sizeof($this->getIds());
    }

    /**
     * Count user compare items without creating new instance
     * @static
     * @return int
     */
    public static function countSession()
    {
        $count = (Yii::$app->session['CompareProducts']) ? Yii::$app->session['CompareProducts'] : [];
        return sizeof($count);
    }

    /**
     * Load ShopAttribute models by names
     * @return array of ShopAttribute models
     */
    public function getAttributes2()
    {

        $this->_products = Product::find()->where(['id' => array_values($this->getIds())])->all();
        $data = $this->getProducts();
        $result = [];

        foreach ($data as $state) {


        }

        foreach ($this->_products as $state) {
            $cid = $state->mainCategory->id;
            // Create the sub-array if it doesn't exist
            if (!isset($result[$cid])) {
                $result[$cid]['items'] = array();
                $result[$cid]['name'] = $state->mainCategory->name;
            }

            // Then append the state onto it
            $result[$cid]['items'][] = array('list1', 'list2'); //$state
            $result[$cid]['name'] = $state->mainCategory->name;
            $result[$cid][$state->id]['attrs'] = [];

            if (isset($result[$cid][$state->id]['attrs'])) {

                $names = [];
                foreach ($this->_products as $p)
                    $names = array_merge($names, array_keys($p->getEavAttributes()));

                $query = Attribute::find();
                $query->where(['in', 'name', $names]);
                $query->displayOnFront();
                $query->useInCompare();
                $query->all();

                if ($query) {

                    foreach ($query as $m) {

                        $result[$cid][$state->id]['attrs'][$m->name] = $m;
                        $result[$cid]['filter_name'][$m->name] = $m;
                    }
                }
            }

        }


        return $result;
    }

    public function getAttributesold()
    {

        $this->_products = Product::model()->findAllByPk(array_values($this->getIds()));
        $result = array();
        foreach ($this->_products as $state) {
            $cid = $state->mainCategory->id;
            // Create the sub-array if it doesn't exist
            if (!isset($result[$cid])) {
                $result[$cid]['items'] = array();
                $result[$cid]['name'] = $state->mainCategory->name;
            }

            // Then append the state onto it
            $result[$cid]['items'][] = $state;
            $result[$cid]['name'] = $state->mainCategory->name;
            if ($result[$cid]['attr'] === null) {
                $result[$cid]['attr'] = array();
                $names = array();
                foreach ($this->_products as $p)
                    $names = array_merge($names, array_keys($p->getEavAttributes()));

                $cr = new CDbCriteria;
                //$cr->with=array('options');
                //$cr->distinct=true;
                // $cr->select = "options.value";
                $cr->addInCondition('t.name', $names);

                $query = Attribute::model()
                    /* ->with(array(
                      'options'=>array(
                      'distinct'=>true,
                      'select'=>'value'
                      )
                      )) */
                    ->displayOnFront()
                    ->useInCompare()
                    ->findAll($cr);

                foreach ($query as $m) {
                    //if(array_unique($m))
                    $result[$cid]['attr'][$m->name] = $m;

                    foreach ($result[$cid]['items'] as $product) {

                        $value = $product->{'eav_' . $m->name};

                        //   echo $value === null ? Yii::t('shop/default', 'Не указано') : $value;
                    }
                }
            }
        }


        return $result;
    }

    public function getAttributesById($id)
    {

        $this->_products = Product::findOne($id);
        $result = array();
        $cid = $this->_products->mainCategory->id;
        // Create the sub-array if it doesn't exist
        if (!isset($result[$cid])) {
            // $result[$cid]['items'] = array();
            //$result[$cid]['name'] = $state->mainCategory->name;
        }

        // Then append the state onto it
        $result[$cid]['items'][] = array('list1', 'list2'); //$state
        $result[$cid]['name'] = $this->_products->mainCategory->name;
        if ($result[$cid][$state->id]['attrs'] === null) {
            $result[$cid][$state->id]['attrs'] = array();
            $names = array();

            $names = array_merge($names, array_keys($this->_products->getEavAttributes()));

            $cr = new CDbCriteria;
            //$cr->with=array('options');
            //$cr->distinct=true;
            // $cr->select = "options.value";
            $cr->addInCondition('t.name', $names);

            $query = ShopAttribute::model()
                /* ->with(array(
                  'options'=>array(
                  'distinct'=>true,
                  'select'=>'value'
                  )
                  )) */
                ->displayOnFront()
                ->useInCompare()
                ->findAll($cr);

            foreach ($query as $m) {
                //if(array_unique($m))
                $result[$cid][$state->id]['attrs'][$m->name] = $m;
                $result[$cid]['filter_name'][$m->name] = $m;
            }
        }


        return $result;
    }

}

/**
 *
 * if ($this->_attributes === null) {
 * $this->_attributes = array();
 * $names = array();
 * foreach ($this->getProducts() as $p)
 * $names = array_merge($names, array_keys($p->getEavAttributes()));
 *
 * $cr = new CDbCriteria;
 * $cr->addInCondition('t.name', $names);
 * $query = ShopAttribute::model()
 * ->displayOnFront()
 * ->useInCompare()
 * ->findAll($cr);
 *
 * foreach ($query as $m)
 * $this->_attributes[$m->name] = $m;
 * }
 * return $this->_attributes;
 */