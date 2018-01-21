<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bills';
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?><small>List of bills</small></h1>
</section>
<section class="content">
    <p class="pull-right" style="margin-right: 15px">
        <button type="button" class="btn btn-primary" onclick="synchronizeChallans()">Synchronize Challans</button>
    </p>
    <div class="col-xs-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => [
                'class' => 'box',
                'style' => 'overflow: auto'
            ],
            'summaryOptions' => [
                'class' => 'box-header'
            ],
            'tableOptions' => [
                'class' => 'table table-bordered table-hover dataTable',
            ],
            'columns' => [
                //'id',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Action',
                    'contentOptions' => ['style' => 'min-width:70px;'],
                ],
                'bill_no',
                [
                    'attribute' => 'company_name',
                    'contentOptions' => ['style' => 'min-width:200px;'],
                ],
                [
                    'attribute' => 'owner_name',
                    'contentOptions' => ['style' => 'min-width:200px;'],
                ],
//                 'floor',
//                 'building',
//                 'market',
//                 'city',
                 'mobile_number',
                 'gst_number',
                [
                    'attribute' => 'order_total',
                    'contentOptions' => ['style' => 'min-width:100px;'],
                ],
                 'CGST',
                 'IGST',
                 'SGST',
                [
                    'attribute' => 'parcel_packing',
                    'contentOptions' => ['style' => 'min-width:100px;'],
                ],
                [
                    'attribute' => 'extra_charges',
                    'contentOptions' => ['style' => 'min-width:100px;'],
                ],
                 'discount',
                [
                    'attribute' => 'net_total',
                    'contentOptions' => ['style' => 'min-width:100px;'],
                ],
                [
                    'attribute' => 'billing_date',
                    'contentOptions' => ['style' => 'min-width:100px;'],
                ],
                 'is_paid',
                [
                    'attribute' => 'received_amount',
                    'contentOptions' => ['style' => 'min-width:80px;'],
                ],
                [
                    'attribute' => 'payment_date',
                    'contentOptions' => ['style' => 'min-width:100px;'],
                ],
                [
                    'attribute' => 'description',
                    'contentOptions' => ['style' => 'min-width:300px;'],
                ],
//                 'created_at',
//                 'modified_at',
            ],
        ]); ?>
    </div>
</section>

<script>
    function synchronizeChallans() {
        var url = '<?= Yii::$app->urlManager->createUrl(['bill/sync']); ?>';
        $.ajax({
            type: "GET",
            url: url,
            success: function () {
                alert("Synchronized successfully");
                window.location.reload();
            }
        })
    }
</script>