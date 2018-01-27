<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->dropDownList($customers,['prompt'=>'Select Customer']); ?>

    <?= $form->field($model, 'product_name')->dropDownList($products,['prompt'=>'Select Product']); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'referred_bill_no')->textInput() ?>

    <?= $form->field($model, 'referred_challan_no')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
