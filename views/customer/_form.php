<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => "Company name"]) ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => true, 'placeholder' => "Owner name"]) ?>

    <?= $form->field($model, 'floor')->textInput(['placeholder' => "0, 1, 2"]) ?>

    <?= $form->field($model, 'building')->textInput(['maxlength' => true, 'placeholder' => "Building name"]) ?>

    <?= $form->field($model, 'market')->textInput(['maxlength' => true, 'placeholder' => "Market name"]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => "City..."]) ?>

    <?= $form->field($model, 'office_phone')->textInput(['maxlength' => true, 'placeholder' => "Landline number"]) ?>

    <?= $form->field($model, 'mobile_1')->textInput(['maxlength' => true, 'placeholder' => "Mobile number"]) ?>

    <?= $form->field($model, 'mobile_2')->textInput(['maxlength' => true, 'placeholder' => "Mobile number"]) ?>

    <?= $form->field($model, 'gst_number')->textInput(['maxlength' => true, 'placeholder' => "GST number"]) ?>

    <?= $form->field($model, 'comments')->textarea(['maxlength' => true, 'rows'=>3, 'placeholder' => "Any special things to note.."]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
