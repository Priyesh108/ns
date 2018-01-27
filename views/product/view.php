<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->name;
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?>
        <small>Have a look over the product</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border" style="padding: 0 10px">
                    <div class="row">
                        <div class="col-xs-3">
                            <h3>Product Details</h3>
                        </div>
                        <div class="col-xs-2 col-xs-offset-6" style="margin-top: 15px">
                            <?= Html::a('Update', ['update', 'id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->product_id], [
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
                            'product_id',
                            'name',
                            'description',
                            'base_price',
                            [
                                'attribute' => 'is_active',
                                'label' => 'Status',
                                'value' => function($data){
                                    if($data->is_active == 1)
                                        return "Active";
                                    else
                                        return "Inactive";
                                }
                            ],
                            [
                                'attribute' => 'unit',
                                'value' => function($data){
                                    if($data->unit == 1)
                                        return "Meters";
                                    else
                                        return "Pieces";
                                }
                            ],
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