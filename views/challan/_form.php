<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Challans */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    /*This style is required for box display*/
    .box-body{
        width: 100% !important;
    }
</style>

<div class="challans-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-material has-error">
        <p id="redistributeError" class="help-block has-error" style="display: none;"></p>
    </div>
    <div class="form-material has-success">
        <p id="redistributeMessage" class="help-block" style="display: none;"></p>
    </div>
    <div class="form-details">
        <div class="row">
            <div class="challam_number" style="display: none;">
                <?= $form->field($model, 'challan_number')->textInput(); ?>
            </div>
            <div class="col-md-5 customer_name">
                <?= $form->field($model, 'customer_id')->dropDownList($customers,['prompt'=>'Select Customer']); ?>
            </div>
            <div class="col-md-5 challan_date">
                <?php echo $form->field($model, 'challan_date')->widget(
                    DatePicker::className(), [
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-M-yyyy',
                        'todayHighlight' => true,
                    ]
                ]); ?>
                <?/*= "Challan Date"; */?><!--
                --><?/*= DatePicker::widget([
                    'model' => $model,
                    'name' => 'challan_date',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'todayHighlight' => true,
                        'format' => 'dd-M-yyyy'
                    ]
                ]); */?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 challan_description">
                <?= $form->field($model,'description')->textarea(['rows'=>4]); ?>
            </div>
        </div>
    </div>
    <table class="table" id="fields">
        <thead>
        <tr>
            <th>Group Number</th>
            <th>Product Name</th>
            <th>Selling Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody class="controls affiliate-control">
        <div>
            <div class="" id="fields">
                <?php if (!empty($challanProducts)) {
                    foreach ($challanProducts as $cp) {
                        $id = $cp['cp_id'];
                        ?>
                        <tr class="existing-fields" id="<?php echo $id; ?>">
                            <td>
                                <div class="product_group">
                                    <input class="form-control" type="text" disabled
                                           name="challanProductModel[group_number]"
                                           value="<?php echo $cp['group_number']; ?>"
                                           id="group_number_<?php echo $id; ?>"/>
                                </div>
                            </td>
                            <td>
                                <div class="product_name">
                                    <?= Html::dropDownList('challanProductModel[product_name]',
                                        \app\models\Products::find()->where(['name'=>$cp['product_name']])->one()->product_id ,
                                        $products,
                                        ['prompt' => 'Select Product','class'=>'form-control dropBtn','id'=>'product_name_'.$id]); ?>
                                </div>
                            </td>
                            <td>
                                <div class="product_price">
                                    <input class="form-control" type="text"
                                           name="challanProductModel[selling_price]"
                                           value="<?php echo $cp['selling_price']; ?>"
                                           id="selling_price_<?php echo $id; ?>"/>
                                </div>
                            </td>
                            <td>
                                <button type='button' class='btn btn-danger btn-remove' id="det_<?= $cp['challan_number'].'_'.$cp['group_number']; ?>"
                                        onclick="removeDisPlanFromDb('<?= $id; ?>')">
                                    <span>-</span>
                                </button>
                                <button type="button" class="btn btn-success detBtn"
                                        id="<?= $id; ?>">
                                    <span>Details</span>
                                </button>
                            </td>
                        </tr>
                    <?php }
                } ?>
                <tr class="add-more-fields">
                    <td>
                        <div class="product_group">
                            <input class="form-control" type="text" disabled
                                   name="challanProductModel[group_number]"
                                   placeholder="Group Number"
                                   id="group_number_<?php echo $newGroupId; ?>"
                                    value="<?php echo $newGroupId; ?>"/>
                        </div>
                    </td>
                    <td>
                        <div class="product_name">
                            <?= Html::dropDownList('challanProductModel[product_name]',
                                '',
                                $products,
                                ['prompt' => 'Select Product','class'=>'form-control dropBtn','id'=>'product_name_'.$newGroupId]); ?>
                        </div>
                    </td>
                    <td>
                        <div class="product_price">
                            <input class="form-control" type="text"
                                   name="challanProductModel[selling_price]" placeholder="Selling Price"
                                   id="selling_price_<?php echo $newGroupId; ?>"/>
                        </div>
                    </td>
                    <td>
                        <button type='button' class='btn btn-success btn-add ' id="det_<?= $model->challan_number.'_'.$newGroupId; ?>">
                            <span>+</span>
                        </button>
                        <button type="button" class="btn btn-success detBtn"
                            id="<?php echo $newGroupId; ?>">
                            <span>Details</span>
                        </button>
                    </td>
                </tr>
            </div>
        </div>
        </tbody>
    </table>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <div class="modal-title">
                        <div class="row">
                            <div class="col-xs-4">Product : <span class="modal_product_name"></span></div>
                            <div class="col-xs-4">Challan : <span class= "modal_challan_number"></span></div>
                            <div class="col-xs-3">Group : <span class="modal_group_number"></span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table" id="modal-fields">
                        <thead>
                        <tr>
                            <th>Base Unit</th>
                            <th>Multiplier Unit</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody class="controls modal-affiliate-control">
                        <div class="modal-added-fields">
                                <tr class="modal-add-more-fields">
                                    <td>
                                        <div class="base_unit">
                                            <input class="form-control unit-change" type="text"
                                                   name="productUnitMapping[base_unit]"
                                                   placeholder="Base Unit""/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="multiplier_unit">
                                            <input class="form-control unit-change" type="text"
                                                   name="productUnitMapping[multiplier_unit]"
                                                   placeholder="Multiplier Unit""/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="total">
                                            <input class="form-control" type="text"
                                                   name="productUnitMapping[total_units]" placeholder="Total"/>
                                        </div>
                                    </td>
                                    <td>
                                        <button type='button' class='btn btn-success modal-btn-add '>
                                            <span>+</span>
                                        </button>
                                    </td>
                                </tr>
                        </div>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <!--<div class=" row final-total">
                        <div class="col-md-2 col-md-offset-7">
                            <label class="total-label">Total Units:</label>
                        </div>
                        <div class="col-md-1">
                            <label class="total_product_units">0</label>
                        </div>
                    </div>-->
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addToProductUnitMapping()">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="form-group">
        <?= Html::submitButton('Save Challan', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancel',Yii::$app->urlManager->createUrl('challan/index'),['class'=>'btn btn-default pull-right']); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script src="<?php echo Yii::getAlias('@web') ?>/js/jquery.min.js"></script>
<script>
    var challan = '<?= $model->challan_number; ?>';

    //For cloning the product entries on the create page
    $(document).on('click', '.btn-add', function (e) {
        e.preventDefault();

        var temp = 1;
        $('[name="challanProductModel[group_number]"]').each(function(){
            var this_number = parseInt($(this).val());
            if(temp < this_number)
                temp = this_number;
        });
        var newGroupNumber = temp + 1;

        var controlForm = $('.affiliate-control:first');
        var currentEntry = $(this).parents('.add-more-fields:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);
        var deleteBtnId = 'det_'+challan+'_'+newGroupNumber;

        newEntry.find('[name="challanProductModel[group_number]"]').attr('value',newGroupNumber);
        newEntry.find('[name="challanProductModel[group_number]"]').attr('id',"group_number_"+newGroupNumber);
        newEntry.find('[name="challanProductModel[product_name]"]').attr('id',"product_name_"+newGroupNumber);
        newEntry.find('[name="challanProductModel[selling_price]"]').attr('id',"selling_price_"+newGroupNumber);
        newEntry.find('[name="challanProductModel[selling_price]"]').val("");
        newEntry.find('.detBtn').attr('id',newGroupNumber);

        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')
            .html('<span>-</span>');

        newEntry.find('.btn-remove').attr('id',deleteBtnId);

    }).on('click', '.btn-remove', function (e) {
        /*if($(this).parent().parent().hasClass('modal-add-more-fields')){
            $(this).parents('.add-more-fields:first').remove();
        } else {*/
            var btnId = $(this).attr('id');
            var res = btnId.split('_');
            var ch_num = res[1];
            var grp_num = res[2];
            //var rowId = 'form_tr_' + res[2];
            var formdata = {'challan_number':ch_num,'group_number':grp_num};
            var url = '<?= Yii::$app->urlManager->createUrl(['challan/delete-challan-product-mapping']); ?>';
            $.ajax({
                url: url,
                type: "POST",
                data: formdata,
                success: function (data) {
                    console.log(data);
                    $('#'+btnId).parent().parent().remove();
                    //$('#'+rowId).remove();
                }
            });
        //}

        return false;
    });

    //For cloning in the modal
    $(document).on('click', '.modal-btn-add', function (e) {
        e.preventDefault();

        var controlForm = $('.modal-affiliate-control:first');
        var currentEntry = $(this).parents('.modal-add-more-fields:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);

        //new entry is already added to modal-add-more-fields class
        var c = parseInt($('.modal-existing-fields').size()) + parseInt($('.modal-add-more-fields').size());
        //Get Last id of the added row
        var lastId = $('[name="productUnitMapping[base_unit]"]').last().attr('id');
        var res = lastId.split("_");
        var last_base_id = parseInt(res[2]);

        newEntry.find('.modal-add-more-fields').attr('id',"modal_tr_" + (last_base_id + 1));
        newEntry.find('[name="productUnitMapping[base_unit]"]').attr('id',"base_unit_"+ (last_base_id + 1));
        newEntry.find('[name="productUnitMapping[multiplier_unit]"]').attr('id',"multiplier_unit_"+ (last_base_id + 1));
        newEntry.find('[name="productUnitMapping[total_units]"]').attr('id',"total_units_"+ (last_base_id + 1));

        newEntry.find('[name="productUnitMapping[base_unit]"]').val("");
        newEntry.find('[name="productUnitMapping[multiplier_unit]"]').val("");
        newEntry.find('[name="productUnitMapping[total_units]"]').val("");


        controlForm.find('.modal-btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('modal-btn-add').addClass('modal-btn-remove')
            .html('<span>-</span>');

    }).on('click', '.modal-btn-remove', function (e) {

        if($(this).parents().hasClass('modal-add-more-fields')){
            $(this).parents('.modal-add-more-fields:first').remove();
        } else {

            var btnId = $(this).attr('id');
            var res = btnId.split('_');
            var rowId = 'modal_tr_' + res[3];

            var formdata = {'pu_id':res[3]};
            var url = '<?= Yii::$app->urlManager->createUrl(['challan/delete-product-unit-mapping']); ?>';
            $.ajax({
               url: url,
               type: "POST",
               data: formdata,
               success: function (data) {
                   console.log(data);
                   $('#'+rowId).remove();
               }
            });
        }
        return false;
    });

    //Clicking on details button
    $(document).on("click",".detBtn",function(){
        var id = this.id;
        var productName = $('#product_name_'+id+' option:selected').text();
        var groupNumber = $('#group_number_'+id).val();
        var sellingPrice = $('#selling_price_'+id).val();
        var cp_id = "";
        if(productName == 'Select Product' && sellingPrice == '')
            alert("Please enter Product Name and Selling Price");
        else {
            var modal = $('#modal-default');

            //Add to challan Product Mapping
            var url = '<?= Yii::$app->urlManager->createUrl(['challan/add-to-challan-product-mapping']); ?>';
            var formData = {'challan':challan,'productName':productName,'groupNumber':groupNumber,'sellingPrice':sellingPrice};
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function (data) {
                    $('#modal-fields').find('.modal-existing-fields').remove();
                    $('#modal-fields').find('.modal-add-more-fields').not(':last').remove();
                    $(data).insertBefore('.modal-add-more-fields');
                    var c = $('.modal-existing-fields').size();
                    //Add id to the last row which is used for addition
                    $('[name="productUnitMapping[base_unit]"]').last().attr('id',"base_unit_"+(parseInt(c) + 1));
                    $('[name="productUnitMapping[multiplier_unit]"]').last().attr('id',"multiplier_unit_"+(parseInt(c) + 1));
                    $('[name="productUnitMapping[total_units]"]').last().attr('id',"total_units_"+(parseInt(c) + 1));

                    $('[name="productUnitMapping[base_unit]"]').last().val("");
                    $('[name="productUnitMapping[multiplier_unit]"]').last().val("");
                    $('[name="productUnitMapping[total_units]"]').last().val("");
                }

            });
            modal.modal('toggle');
            modal.find('.modal_product_name').text(productName);
            modal.find('.modal_challan_number').text(challan);
            modal.find('.modal_group_number').text(groupNumber);
        }
    });
    
    $(document).on('change','.unit-change',function () {
        var id = this.id;
        var res = id.split("_");
        var base_id = res[2];

        var base_unit = parseFloat($('#base_unit_'+base_id).val());
        var mul_unit = parseFloat($('#multiplier_unit_'+base_id).val());
        var res = base_unit*mul_unit;

        $('#total_units_'+base_id).val(res);
        /*var productTotal = parseFloat($('.total_product_units').text());
        console.log(productTotal);
        if(!$.isNumeric(productTotal)){
            productTotal = 0;
        }
        productTotal += res;
        $('.total_product_units').text(productTotal);*/
    });

    function addToProductUnitMapping() {
        var base_unit = [];
        var mul_unit = [];
        var total_units = [];
        var ch_no = $('.modal_challan_number').html();
        var grp_no = $('.modal_group_number').html();
        var url = '<?= Yii::$app->urlManager->createUrl(['challan/add-to-product-unit-mapping']); ?>';
        $("[name='productUnitMapping[base_unit]']").each(function () {
            if (this.value != "") base_unit.push(this.value);
        });
        $("[name='productUnitMapping[multiplier_unit]']").each(function () {
            if (this.value != "") mul_unit.push(this.value);
        });
        $("[name='productUnitMapping[total_units]']").each(function () {
            var id = this.id;
            var res = id.split("_");
            var base_id = res[2];

            var base_unit_value = parseFloat($('#base_unit_'+base_id).val());
            var mul_unit_value = parseFloat($('#multiplier_unit_'+base_id).val());
            var total_units_value = base_unit_value * mul_unit_value;
            $('#total_units_'+base_id).val(total_units_value);
            total_units.push(total_units_value);
            //if (this.value != "") total_units.push(this.value);
        });
        if(base_unit.length == mul_unit.length){
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    base_unit: base_unit,
                    mul_unit: mul_unit,
                    total_units: total_units,
                    challan_number: ch_no,
                    group_number: grp_no
                },
                success: function (data) {
                    console.log("Data Saved Successfully");
                    $('#modal-default').modal('toggle');
                }
            });
        }
    }
    $('#modal-default').on('hidden.bs.modal', function () {
        // do something…
        $('[name="productUnitMapping[base_unit]"]').last().removeAttr('id');
        $('[name="productUnitMapping[multiplier_unit]"]').last().removeAttr('id');
        $('[name="productUnitMapping[total_units]"]').last().removeAttr('id');
    });

    //Get Selling Price
    $('.dropBtn').change(function () {
        var customer_id = $('#challans-customer_id option:selected').val();
        if(customer_id == ""){
            alert("Please select customer");
            $(this).find('option:first').attr('selected', 'selected');
        }
        var val = this.value;
        var id = $(this).attr('id');
        var res = id.split('_');
        var base_id = res[2];
        var price = '';
        var url = '<?= Yii::$app->urlManager->createUrl('price/get-price'); ?>';
        if(val != ''){
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    customer_id: customer_id,
                    product_id: val
                },
                success:function (data) {
                    price = data;
                    $('#selling_price_'+base_id).val(price);
                }
            });
        }
    });
</script>