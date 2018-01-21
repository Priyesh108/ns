<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-form">

    <div class="form-material has-error">
        <p id="redistributeError" class="help-block has-error" style="display: none;"></p>
    </div>
    <div class="form-material has-success">
        <p id="redistributeMessage" class="help-block" style="display: none;"></p>
    </div>

    <div class="form-details">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'floor')->textInput() ?>

        <?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'market')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'gst_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'order_total')->textInput() ?>

        <?= $form->field($model, 'CGST')->textInput() ?>

        <?= $form->field($model, 'IGST')->textInput() ?>

        <?= $form->field($model, 'SGST')->textInput() ?>

        <?= $form->field($model, 'parcel_packing')->textInput() ?>

        <?= $form->field($model, 'extra_charges')->textInput() ?>

        <?= $form->field($model, 'discount')->textInput() ?>

        <?= $form->field($model, 'net_total')->textInput() ?>

        <?= $form->field($model, 'billing_date')->textInput() ?>

        <?= $form->field($model, 'is_paid')->textInput() ?>

        <?= $form->field($model, 'received_amount')->textInput() ?>

        <?= $form->field($model, 'payment_date')->textInput() ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'modified_at')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
