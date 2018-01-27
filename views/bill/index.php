<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bills';
?>
<style>
    /*This style is required for box display*/
    .full-width{
        width: 100% !important;
    }
</style>
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
                [
                    'class' => 'yii\grid\ActionColumn',
                    //'format' => 'html',
                    'header' => "Payment Status",
                    'template' => '{billPaid}',
                    'buttons' => [
                            'billPaid' => function($url, $model, $key){
                                if($model->is_paid == 0)
                                    return Html::button('Unpaid',['class'=>'btn btn-danger btn-sm','onclick'=>'unpaid('.$key.')']);
                                else
                                    return Html::label('Paid','',['class'=>'label label-success', 'style'=>'margin-left:7px;font-size:100%']);
                            }
                    ]
                    /*'value' => function($data){
                        if($data->is_paid == 0){
                            $str = "<a type=\"button\" class = \"btn btn-danger btn-sm\" href=\"unpaid/$data->id\">Unpaid</a>";
                            return $str;
                        } else{
                            $str = "<span class = \"label label-success\">Paid</span>";
                            return $str;
                        }
                    }*/
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

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <div class="modal-title">
                        <div class="row">
                            <div class="col-xs-8"><h3>Bill Details</h3></div>
                            <div class="col-xs-4"><h5 class="box-title">Billing Date : <span class= "modal_bill_date"></span></h5></div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-md-3">
                            <span class="modal-label control-label">Net Total :</span>
                        </div>
                        <div class="col-md-6">
                            <?= Html::input('number','modal_net_total','',['class'=>'modal_net_total full-width form-control', 'disabled' => 'true']) ?>
                            <?= Html::input('number','modal_bill_id','',['class'=>'modal_bill_id full-width form-control', 'style' => 'display:none']) ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <span class="modal-label">Discount :</span>
                        </div>
                        <div class="col-md-6">
                            <?= Html::input('number','modal_discount','',['class'=>'modal_discount full-width form-control']) ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <span class="modal-label">Received Amount :</span>
                        </div>
                        <div class="col-md-6">
                            <?= Html::input('number','modal_received_amount','',['class'=>'modal_received_amount full-width form-control', 'disabled' => 'true']) ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <span class="modal-label">Payment Date :</span>
                        </div>
                        <div class="col-md-6">
                            <?= Html::input('date','modal_payment_date','',['class'=>'modal_payment_date full-width form-control']) ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <span class="modal-label">Description :</span>
                        </div>
                        <div class="col-md-6">
                            <?= Html::textarea('modal_description','',['class'=>'modal_description full-width form-control','rows'=>'4']) ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="markItPaid()">Mark It Paid</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</section>
<script src="<?php echo Yii::getAlias('@web') ?>/js/jquery.min.js"></script>
<script>

    //Onchange event for discount in bill
    $('.modal_discount').on('change keyup paste', function() {
        var discount = $(this).val();
        var net_total = $('.modal_net_total').val();
        $('.modal_received_amount').val(net_total - discount);
    });

    function synchronizeChallans() {
        var url = '<?= Yii::$app->urlManager->createUrl(['bill/sync']); ?>';
        $.ajax({
            type: "GET",
            url: url,
            success: function () {
                alert("Synchronized successfully");
                window.location.reload();
            }
        });
    }
    function unpaid(id) {
        var url = '<?= Yii::$app->urlManager->createUrl(['bill/get-details']) ?>'+'?id='+id;
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                var res = JSON.parse(data);
                $('.modal_bill_date').html(res.billing_date);
                $('.modal_net_total').val(res.net_total);
                $('.modal_bill_id').val(id);
                $('.modal_discount').val(res.discount);
                $('.modal_received_amount').val(res.received_amount);
                $('.modal_payment_date').val(res.payment_date);
                $('.modal_description').val(res.desciption);
            }
        });
        var modal = $('#modal-default');
        modal.modal('toggle');
    }
    function markItPaid() {
        var url = '<?= Yii::$app->urlManager->createUrl(['bill/bill-paid']); ?>';
        var bill_id = $('.modal_bill_id').val();
        var received_amount = $('.modal_received_amount').val();
        var net_total = $('.modal_net_total').val();
        var discount = $('.modal_discount').val();
        var description = $('.modal_description').val();
        var payment_date = $('.modal_payment_date').val();
        $.ajax({
            url: url,
            type: "POST",
            data: {
                bill_id: bill_id,
                received_amount: received_amount,
                net_total: net_total,
                discount: discount,
                description: description,
                payment_date: payment_date
            },
            success: function (data) {
                window.location.reload();
            }
        })
    }
</script>