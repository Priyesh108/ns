<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */

$this->title = "Bill Number: ".$model->bill_no;
?>


<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

<!--    <p>-->
<!--        --><?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::a('Delete', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->
<section class="content-header">
    <h1>Bill Number <small>#<?= $model->bill_no; ?></small></h1>
</section>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Nilam Synthetics
                <small class="pull-right">Date: 2/10/2014</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Nilam Synthetics</strong><br>
                9, A.K.Shah Bldg., Extra Gali,<br>
                Sindhi Market, Revdi Bazar,<br>
                Ahmedabad-2, Gujarat (Code:24)<br>
                Phone: (079)22168151<br>
                Mobile: 98251-56797<br>
                GST: 24AAOPD7823N1ZC
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong><?= $model->company_name; ?></strong><br>
                <?= $model->owner_name; ?><br>
                <?= $model->floor.', '.$model->building.','; ?><br>
                <?= $model->market.',' ?><br>
                <?= $model->city.', '.$model->state; ?><br>
                Mobile: <?= $model->mobile_number; ?><br>
                GST: <?= $model->gst_number; ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Bill: </b> #<?= $model->bill_no; ?><br>
            <b>Challan Number: </b><?= implode(', ', $challan_numbers); ?><br><br>
            <b>Billing Date: </b> <?= date('d-M-Y', strtotime($model->billing_date)) ;?><br>
            <b>Payment Due: </b> <?= date('d-M-Y', strtotime("+3 months", strtotime($model->billing_date))) ;?> <br>
            <!--<b>Description: </b> --><?/*= $model->description; */?>
        </div>
    </div>
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productGroups as $i=>$group){ ?>
                        <tr>
                            <td><?= $i+1; ?></td>
                            <td><?= $group['product_name']; ?></td>
                            <td><?= $group['total_units']; ?></td>
                            <td><?= Yii::$app->servicehelper->getProductUnit($group['unit']); ?></td>
                            <td><?= $group['selling_price']; ?></td>
                            <td><?= $group['amount']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--Bank Details-->
    <div class="row">
        <div class="col-xs-6">
            <p class="lead">Bank Details:</p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Bank: </th>
                        <td>Bank Of India</td>
                    </tr>
                    <tr>
                        <th>Account Number:</th>
                        <td>1024245253434</td>
                    </tr>
                </table>
            </div>
            <?php if($model->is_paid == 1) { ?>
                <p class="lead">Payment Received:</p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Received Amount:</th>
                            <td><?= $model->received_amount; ?></td>
                        </tr>
                        <tr>
                            <th>Payment Date:</th>
                            <td><?= date('d-M-Y', strtotime($model->payment_date)) ;?></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td><?= $model->description ;?></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>

        </div>
        <div class="col-xs-6">
            <p class="lead">Payment Details:</p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal: </th>
                        <td><?= $model->order_total; ?></td>
                    </tr>
                    <tr>
                        <th>CGST:</th>
                        <td><?= $model->CGST; ?></td>
                    </tr>
                    <?php if(isset($model->IGST)) { ?>
                        <tr>
                            <th>IGST:</th>
                            <td><?= $model->IGST; ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <th>SGST:</th>
                            <td><?= $model->SGST; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if(isset($model->parcel_packing)) { ?>
                        <tr>
                            <th>Parcel Packing:</th>
                            <td><?= $model->parcel_packing; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if(isset($model->extra_charges)) { ?>
                        <tr>
                            <th>Extra Charges:</th>
                            <td><?= $model->extra_charges; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if(isset($model->discount)) { ?>
                        <tr>
                            <th>Discount:</th>
                            <td><?= $model->discount; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if(isset($model->net_total)) { ?>
                        <tr>
                            <th>Net Total:</th>
                            <td><?= $model->net_total; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</section>