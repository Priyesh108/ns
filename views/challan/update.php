<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Challans */

$this->title = 'Update Challan: ' . $model->challan_number;
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?>
        <small>Update challan details</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>Challan Details</h3>
                </div>
                <div class="box-body" style="width: 450px">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'challanProducts' => $challanProducts,
                        'newGroupId' => $newGroupId,
                        'customers' => $customers,
                        'products' => $products
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</section>