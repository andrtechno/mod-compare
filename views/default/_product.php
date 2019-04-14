<?php
use panix\engine\Html;

?>


<div class="product">
    <div class="product-box clearfix">

        <div class="clearfix gtile-i-150-minheight">
            <?php
            echo Html::a(Html::img($data->getMainImage('240x240')->url, ['alt' => $data->getMainImage()->title]), $data->getUrl(), array('class' => 'thumbnail'));
            ?>
        </div>


        <div class="product-title">
            <?php echo Html::a(Html::encode($data->name), $data->getUrl()) ?>
        </div>

        <div class="product-price">

            <?php
            if (Yii::$app->hasModule('discounts')) {
                if ($data->appliedDiscount) {
                    echo '<span class="price price-discount"><del>' . $data->toCurrentCurrency('originalPrice') . '</del></span>';
                }
            }
            ?>
            <span class="price">
                <?= $data->priceRange() ?></span>
            <sup><?= Yii::$app->currency->active->symbol ?></sup>
        </div>

        <?php
        echo $data->beginCartForm();
        if (Yii::$app->hasModule('cart')) {
            if ($data->isAvailable) {
                echo Html::a(Yii::t('cart/default', 'BUY'), 'javascript:cart.add(' . $data->id . ')', ['class' => 'btn btn-warning', 'onClick' => '']);
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



        <?php echo $data->full_description; ?>


    </div>
</div>









