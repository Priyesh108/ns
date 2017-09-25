<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>


<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'fieldConfig' => [
        'template' => "{input}{error}",
    ],
]); ?>

<?= $form->field($model, 'email', [
    'template' => "<div class=\"has-feedback\">{input}
                            <span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span></div>
                            {error}"
])->textInput(['type' => 'email', 'class' => 'form-control', 'placeholder' => "Email"]); ?>

<?= $form->field($model, 'password', [
    'template' => "<div class=\"has-feedback\">{input}
                            <span class=\"glyphicon glyphicon-lock form-control-feedback\"></span></div>
                            {error}"
])->passwordInput()->hint("Password"); ?>

<div class="row">
    <div class="col-xs-8">
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "{input} {label}",
        ]) ?>
    </div>

    <div class="col-xs-4">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

