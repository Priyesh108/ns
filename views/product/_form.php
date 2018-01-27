<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => "Product name"]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => "Any specific description...", 'rows'=>3]) ?>

    <?= $form->field($model, 'base_price')->textInput(['placeholder' => "Base selling price"]) ?>

    <?= $form->field($model, 'unit')->dropDownList(['1'=>"Meters",'2'=>'Pieces']); ?>

    <?= $form->field($model, 'is_active')->dropDownList(['1'=>"Active",'2'=>'Inactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
