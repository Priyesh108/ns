<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    /*This style is required for box display*/
    .box-body{
        width: 100% !important;
    }
</style>

<div class="bill-form">

    <div class="form-material has-error">
        <p id="redistributeError" class="help-block has-error" style="display: none;"></p>
    </div>
    <div class="form-material has-success">
        <p id="redistributeMessage" class="help-block" style="display: none;"></p>
    </div>

    <div class="form-details">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'gst_number')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'order_total')->textInput([ 'readonly'=>true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'CGST')->textInput([ 'readonly'=>true]) ?>
            </div>
            <div class="col-md-5">
                <?php if($customer->IGST == 1) { ?>
                    <?= $form->field($model, 'IGST')->textInput([ 'readonly'=>true]) ?>
                <?php } else { ?>
                    <?= $form->field($model, 'SGST')->textInput([ 'readonly'=>true]) ?>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'parcel_packing')->textInput() ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'extra_charges')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <?/*= $form->field($model, 'discount')->textInput() */?>
            </div>
            <div class="col-md-5">

            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'net_total')->textInput(['readonly'=>true]) ?>
            </div>
            <div class="col-md-5">
                <?php echo $form->field($model, 'billing_date')->widget(
                    DatePicker::className(), [
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-M-yyyy',
                        'todayHighlight' => true,
                    ]
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'description')->textarea(['rows'=>4]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>