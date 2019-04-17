<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

$isType = isset($_POST['CompareForm']['type']) ? (int)$_POST['CompareForm']['type'] : 0;

?>

<h1><?= $this->context->pageName; ?></h1>




<table class="compareTable table table-bordered">
    <tr>
        <td style="width: 200px">sdadsa</td>
        <td rowspan="2">products</td>
    </tr>
    <tr>
        <td style="width: 200px">attributes</td>

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
