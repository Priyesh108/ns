<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'bill_no',
            'company_name',
            'owner_name',
            'floor',
            'building',
            'market',
            'city',
            'mobile_number',
            'gst_number',
            'order_total',
            'CGST',
            'IGST',
            'SGST',
            'parcel_packing',
            'extra_charges',
            'discount',
            'net_total',
            'billing_date',
            'is_paid',
            'received_amount',
            'payment_date',
            'description',
            'created_at',
            'modified_at',
        ],
    ]) ?>

</div>
