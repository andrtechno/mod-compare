<?php
use panix\engine\Html;

/** @var \panix\mod\shop\models\Product $data */
?>


<div class="product">
    <div class="product-label-container">
        <?php
        foreach ($data->labels() as $label) {
            echo '<div>';
            echo Html::tag('span', $label['value'], [
                'class' => 'product-label-tag badge badge-' . $label['class'],
                'data-toggle' => 'tooltip',
                // 'title' => $label['tooltip']
            ]);
            echo '</div>';
        }
        ?>
    </div>
    <div class="product-image d-flex justify-content-center align-items-center">
        <?php
        echo Html::a(Html::img($data->getMainImage('340x265')->url, ['alt' => $data->name, 'class' => 'img-fluid loading']), $data->getUrl(), []);
        ?>
    </div>
    <div class="product-info">
        <?= Html::a(Html::encode($data->name), $data->getUrl(), ['class' => 'product-title']) ?>
    </div>


    <div class="row no-gutters mt-2">
        <div class="col-6 col-sm-6 col-lg-7 d-flex align-items-center">
            <div class="product-price">

                <?php
                if (Yii::$app->hasModule('discounts')) {
                    if ($data->appliedDiscount) {
                        ?>
                        <span class="price price-discount">
                                <span><?= Yii::$app->currency->number_format(Yii::$app->currency->convert($data->originalPrice)) ?></span>
                                <sub><?= Yii::$app->currency->active['symbol'] ?></sub>
                            </span>
                        <span class="discount-sum">-<?= $data->discountSum; ?></span>
                        <?php
                    }
                }
                ?>
                <div>
                    <span class="price"><span><?= $data->priceRange() ?></span> <sub><?= Yii::$app->currency->active['symbol'] ?></sub></span>
                </div>


            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-5 text-right">
            <?php
            if (Yii::$app->hasModule('cart')) {
                if ($data->isAvailable) {
                    echo $data->beginCartForm();
                    echo Html::a(Yii::t('cart/default', 'BUY'), 'javascript:cart.add(' . $data->id . ')', array('class' => 'btn btn-warning btn-buy'));
                    echo $data->endCartForm();
                } else {
                    \panix\mod\shop\bundles\NotifyAsset::register($this);
                    echo Html::a(Yii::t('shop/default', 'NOT_AVAILABLE'), 'javascript:notify(' . $data->id . ');', array('class' => 'text-danger'));
                }


            }

            ?>
        </div>
        <div class="text-center">
            <?php
            echo Html::a(Yii::t('app/default', 'DELETE'), ['/compare/default/remove', 'id' => $data->id], [
                'class' => 'btn2 btn-link2 text-danger remove',
            ]);
            ?>
        </div>
    </div>


</div>









