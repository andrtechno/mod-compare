
<?php
use panix\engine\Html;
?>








<div class="product">
    <div class="product-box clearfix">

        <div class="clearfix gtile-i-150-minheight">
            <?php
            echo Html::a(Html::img($data->getMainImage('240x240')->url, ['alt'=>$data->getMainImage()->title]), $data->getUrl(), array('class' => 'thumbnail'));
            ?>
        </div>


        <div class="product-title">
            <?php echo Html::a(Html::encode($data->name), $data->getUrl()) ?>
        </div>

        <div class="product-price">
            <span class="price">
                <?php
                if (Yii::$app->hasModule('discounts')) {
                    if ($data->appliedDiscount) {
                        echo '<span style="color:red; "><s>' . $data->toCurrentCurrency('originalPrice') . '</s></span>';
                    }
                }
                ?>
                <?= $data->priceRange() ?></span>
            <sup><?= Yii::$app->currency->active->symbol ?></sup>
        </div>

        <?php
        echo $data->beginCartForm();
        if (Yii::$app->hasModule('cart')) {
            if ($data->isAvailable) {
                echo Html::a(Yii::t('shop/default', 'BUY'), 'javascript:shop.addCart(' . $data->id . ')', ['class' => 'button btn-green cart', 'onClick' => '']);
                //   echo Html::button(Yii::t('shopModule.default', 'BUY'), array('class' => 'button btn-green cart', 'onClick' => 'shop.addCart(' . $data->id . ')'));
            } else {
                echo Html::a('Нет в наличии', 'javascript:shop.notifier(' . $data->id . ');');
            }
        }
        echo $data->endCartForm();
        ?>

        <?php
        echo Html::a(Yii::t('app', 'DELETE'), ['/compare/default/remove', 'id' => $data->id], [
            'class' => 'remove',
        ]);
        ?>



        <ul class="product-detail">
            <li><?php echo $data->full_description; ?></li>
        </ul>

    </div>
</div>









