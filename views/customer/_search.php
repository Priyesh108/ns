<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'owner') ?>

    <?= $form->field($model, 'floor') ?>

    <?= $form->field($model, 'building') ?>

    <?php // echo $form->field($model, 'market') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'office_phone') ?>

    <?php // echo $form->field($model, 'mobile_1') ?>

    <?php // echo $form->field($model, 'mobile_2') ?>

    <?php // echo $form->field($model, 'gst_number') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
