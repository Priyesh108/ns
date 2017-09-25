<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Update Product: ' . $model->name;
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?>
        <small>Update product details</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>Product Details</h3>
                </div>
                <div class="box-body" style="width: 450px">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</section>