<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

/**
 * @var \panix\mod\compare\forms\CompareForm $compareForm
 */
$isType = isset($_POST['CompareForm']['type']) ? (int)$_POST['CompareForm']['type'] : 0;


//var_dump(Yii::$app->request->get('cat_id'));

$items = $result[$cat_id]['items'];


?>

<h1><?= $this->context->pageName; ?></h1>


<div class="table-responsive">
    <table class="compareTable table table-bordered">
        <thead>
        <tr>
            <td width="200px">
                <div class="compare-count-products">
                    / <?= Yii::t('shop/default', 'PRODUCTS_COUNTER', count($this->context->model->getIds())) ?> </div>
                <ul class="list-unstyled compare-categories-list text-uppercase">
                    <?php
                    foreach ($result as $id => $group) {
                        $categoryArray[] = $id;
                        $gp[$id] = $group;
                        $class = ($cat_id == $id) ? 'active' : '';
                        ?>
                        <li class="<?= $class ?>"><?= Html::a($group['name'], ['/compare/default/index', 'cat_id' => $id]) ?></li>
                    <?php } ?>
                </ul>

                <?php
                $form = ActiveForm::begin([
                    'options' => ['id' => 'compare-form']
                ]);

                echo $form->field($compareForm, 'type')
                    ->radioList([0 => Yii::t('compare/default', 'ALL'), 1 => Yii::t('compare/default', 'ONLY_DIFF')])
                    ->hint(Yii::t('compare/default', 'HINT'));
                ?>
                <?php ActiveForm::end(); ?>
            </td>
            <?php


            foreach ($items as $p) { ?>
                <td>
                    <div class="products_list">
                        <?php

                        echo $this->render('_product', ['data' => $p]);

                        ?>
                    </div>
                </td>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        // \yii\helpers\VarDumper::dump($group,10,true);die;
        foreach ($result[$cat_id]['attributes'] as $attribute) {
            $flag = false;
            if ($isType) {
                $unq = [];

                foreach ($items as $product) {

                    $unq[] = (string)$product->{'eav_' . $attribute->name};
                }

                foreach (array_count_values($unq) as $pid => $count) {
                    $flag = true;

                    if ($count == count($items)) {
                        $flag = false;
                    }
                }
            } else {
                $flag = true;
            }
            if ($flag) {
                ?>
                <tr>
                    <td class="attr"><?= $attribute->title ?></td>
                    <?php foreach ($items as $product) {
                        ?>
                        <td class="text-center">
                            <?php
                            $value = $product->{'eav_' . $attribute->name};
                            echo $value === null ? '<span class="text-danger">'.Yii::t('yii', '(not set)').'</span>' : $value;
                            ?>
                        </td>
                    <?php } ?>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
<?php


$this->registerJs("
    $(function () {
    
        $('#tabs').tabs();
        
        var result = new Array();

        $('.compareTable tbody tr td:not(.attr)').each(function (k, obj) {
            var value = $.trim($(obj).text());
            var row = $(obj).closest('td');
            var clone = row.clone();

            console.log(row);
            // console.log(clone);


            /*  if (($(this).text() != '') && ($(this).text() != ' ')) {
             if (result.indexOf($(this).text()) == -1) {
             result.push(+($(this).text()));
             }
             }*/
        });
        
        
        $('#compareform-type input').change(function () {
            $('#compare-form').submit();
        });
        // alert(result);
    });
");
?>
