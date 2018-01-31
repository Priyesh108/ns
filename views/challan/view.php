<?php

use app\models\ChallanProductMapping;
use app\models\Customers;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Challans */

$this->title = "Challan Number: ".$model->challan_number;
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border" style="padding: 0 10px">
                    <div class="row">
                        <div class="col-xs-3">
                            <h3>Challan Details</h3>
                        </div>
                        <?php if($model->is_billed == 0) { ?>
                            <div class="col-xs-2 col-xs-offset-5" style="margin-top: 15px">
                                <?= Html::a('Update', ['update', 'id' => $model->c_id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Delete', ['delete', 'id' => $model->c_id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                            <div class="col-xs-2">
                                <button type="button" style="margin-right: 30px;margin-top: 15px;" class="btn btn-success pull-right" onclick="createBill()">Create Bill</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'challan_number',
                            [
                                'label' => 'Customer',
                                'value' => Customers::findOne($model->customer_id)->name
                            ],
                            'amount',
                            [
                                'attribute' => 'challan_date',
                                'format' => ['date', 'medium']
                            ],
                            'description',
                            'is_merged',
                            'is_billed',
                            [
                                'attribute' => 'billing_date',
                                'format' => ['date', 'medium']
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($productUnits as $cp_id=>$pu) {?>
                <?php $cpm = ChallanProductMapping::findOne($cp_id); ?>
                <div class="col-md-3">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $cpm->product_name.' ('.$cpm->selling_price.')'; ?></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Base Unit</th>
                                        <th>Multiplier Unit</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $final_units = 0;?>
                                    <?php foreach ($pu as $item) {?>
                                        <tr>
                                            <td><?= $item['base_unit']; ?></td>
                                            <td><?= $item['multiplier_unit']; ?></td>
                                            <td><?= $item['total_units']; ?></td>
                                            <?php $final_units += $item['total_units']; ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            Total Units: <?= $final_units; ?>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>

        <?php } ?>
    </div>
</section>
<script src="<?php echo Yii::getAlias('@web') ?>/js/jquery.min.js"></script>
<script>
    var challan = '<?= $model->challan_number; ?>';
    var challanStatus = '<?= Yii::$app->servicehelper->getChallanState($model->challan_number); ?>';
    function createBill() {
        if(challanStatus == 2){
            alert("Challan is already clubbed with other Challans. Separate bill can not be prepared.");
        } else if(challanStatus == 3){
            alert("Bill is already prepared for this challan.");
        } else {
            if(challanStatus == 1){
                var createBillUrl = '<?= Yii::$app->urlManager->createUrl(['bill/create-challan-specific-bill']); ?>';
                $.ajax({
                    type: "POST",
                    url: createBillUrl,
                    data: {
                        challan_number: challan
                    },
                    success: function (data) {
                        alert("Bill was created successfully.");
                        window.location.reload();
                    }
                });
            }
        }
    }
</script>
