<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Challans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="challans-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->dropDownList($customers, ['class' => 'select2 form-control', 'prompt' => 'Select User']) ?>

    <div class="box-header with-border">
        <h3>Add Products</h3>
    </div>
    <div class="add_product">
        <?php foreach($challanProducts as $i=>$cp) {?>
            <?= $form->field($challanProducts[$i], 'product_id')->dropDownList($products, ['class' => 'select2 form-control', 'prompt' => 'Select User']) ?>
        <?php } ?>
    </div>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'challan_date')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_merged')->textInput() ?>

    <?= $form->field($model, 'is_billed')->textInput() ?>

    <?= $form->field($model, 'billing_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="<?php echo Yii::getAlias('@web') ?>/js/jquery.min.js"></script>