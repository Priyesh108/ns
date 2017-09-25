<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChallansSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="challans-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'c_id') ?>

    <?= $form->field($model, 'challan_number') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'challan_date') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'is_merged') ?>

    <?php // echo $form->field($model, 'is_billed') ?>

    <?php // echo $form->field($model, 'billing_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
