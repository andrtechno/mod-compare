<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

$isType = isset($_POST['CompareForm']['type']) ? (int)$_POST['CompareForm']['type'] : 0;

?>

<h1><?= $this->context->pageName; ?></h1>


<?php


//echo \yii\helpers\VarDumper::dump($this->context->model->products,10,true);die;

$result = $this->context->model->products;
?>

<table class="compareTable table table-bordered">
    <tr>
        <td style="width: 200px">

            <?php foreach ($result as $category_id => $data) { ?>




                    <?php
echo Html::a($data['name'],['/compare/default/index','cat_id'=>$category_id],[]);
                    ?>

            <?php }

           // echo \yii\helpers\VarDumper::dump($this->context->model->products,4,true);
            //die;
            ?>


        </td>
        <td rowspan="2">

            <?php foreach ($result[102]['items'] as $product) { ?>




                    <?php
                  //  print_r($p->name);
                    var_dump($product->eav_size);
                    ?>

            <?php } ?>




        </td>
    </tr>
    <tr>
        <td style="width: 200px">
            <?php

            // echo \yii\helpers\VarDumper::dump($result[102]['attributes'],4,true);die;

            ?>
            <?php //foreach ($result as $product) { ?>

                <?php foreach ($result[102]['attributes'] as $attribute_name => $attribute) { ?>


                        <div>
                            <?php
                          echo $attribute->title;
                            ?>
                        </div>



                <?php } ?>
            <?php //} ?>

        </td>

    </tr>
</table>


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
