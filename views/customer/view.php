<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = $model->name;
?>
<style>
    table.detail-view th {
        width: 25%;
    }

    table.detail-view td {
        width: 75%;
    }
</style>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?>
        <small>Have a look over the customer</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border" style="padding: 0 10px">
                    <div class="row">
                        <div class="col-xs-3">
                            <h3>Customer Details</h3>
                        </div>
                        <div class="col-xs-2 col-xs-offset-6" style="margin-top: 15px">
                            <?= Html::a('Update', ['update', 'id' => $model->customer_id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->customer_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'owner',
                            'floor',
                            'building',
                            'market',
                            'city',
                            'office_phone',
                            'mobile_1',
                            'mobile_2',
                            'gst_number',
                            'comments',
                            [
                                'attribute' => 'created_at',
                                'format' => ['date', 'medium']
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>