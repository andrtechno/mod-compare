<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

$isType = isset($_POST['CompareForm']['type']) ? (int)$_POST['CompareForm']['type'] : 0;

?>

<h1><?= $this->context->pageName; ?></h1>
<?php
foreach ($this->context->model->products as $id => $group) {
    ?>


    <div class="table-responsive">
        <table class="compareTable table table-bordered">
            <thead>
            <tr>
                <td width="200px">
                    <div class="compare-count-products">/ <?= count($this->context->model->getIds()) ?> товаров</div>
                    <ul class="list-unstyled compare-categories-list text-uppercase">
                        <?php
                        foreach ($this->context->model->products as $id => $group) {
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
                <?php foreach ($group['items'] as $p) { ?>
                    <td>
                        <div class="products_list wish_list">
                            <?php echo $this->render('_product', ['data' => $p]) ?>
                        </div>
                    </td>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php
            // \yii\helpers\VarDumper::dump($group,10,true);die;
            foreach ($group['attributes'] as $attribute) {
                if ($isType) {
                    $unq = [];

                    foreach ($group['items'] as $product) {

                        $unq[] = (string)$product->{'eav_' . $attribute->name};
                    }

                    foreach (array_count_values($unq) as $pid => $count) {
                        $flag = true;

                        if ($count == count($group['items'])) {
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
                        <?php foreach ($group['items'] as $product) {
                            ?>
                            <td>
                                <?php
                                $value = $product->{'eav_' . $attribute->name};
                                echo $value === null ? Yii::t('shop/default', 'Не указано') : $value;
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
}


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
