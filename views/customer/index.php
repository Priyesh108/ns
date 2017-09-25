<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?><small>List of customers</small></h1>
</section>
<section class="content">
    <p class="pull-right" style="margin-right: 15px">
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-xs-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => [
                'class' => 'box',
                'style' => 'overflow: auto'
            ],
            'summaryOptions' => [
                'class' => 'box-header'
            ],
            'tableOptions' => [
                'class' => 'table table-bordered table-hover dataTable',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'contentOptions' => ['style' => 'min-width:200px;'],
                ],
                [
                    'attribute' => 'owner',
                    'contentOptions' => ['style' => 'min-width:200px;'],
                ],
                'floor',
                [
                    'attribute' => 'building',
                    'contentOptions' => ['style' => 'min-width:200px;'],
                ],
                [
                    'attribute' => 'market',
                    'contentOptions' => ['style' => 'min-width:200px;'],
                ],
                 'city',
                 'office_phone',
                 'mobile_1',
                 'mobile_2',
                 'gst_number',
                 'comments',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Action',
                    'contentOptions' => ['style' => 'min-width:70px;'],
                ],
            ],
        ]); ?>
    </div>
</section>
