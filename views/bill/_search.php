<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BillSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bill_no') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'owner_name') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'building') ?>

    <?php // echo $form->field($model, 'market') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'mobile_number') ?>

    <?php // echo $form->field($model, 'gst_number') ?>

    <?php // echo $form->field($model, 'order_total') ?>

    <?php // echo $form->field($model, 'CGST') ?>

    <?php // echo $form->field($model, 'IGST') ?>

    <?php // echo $form->field($model, 'SGST') ?>

    <?php // echo $form->field($model, 'parcel_packing') ?>

    <?php // echo $form->field($model, 'extra_charges') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'net_total') ?>

    <?php // echo $form->field($model, 'billing_date') ?>

    <?php // echo $form->field($model, 'is_payed') ?>

    <?php // echo $form->field($model, 'received_amount') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
