<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prices';
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?><small>Customer-Price Mapping</small></h1>
</section>
<section class="content">
    <p class="pull-right" style="margin-right: 15px">
        <?= Html::a('Add New', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Action',
                    'contentOptions' => ['style' => 'min-width:70px;'],
                ],
                'customer_name',
                'product_name',
                'price',
                'referred_bill_no',
                'referred_challan_no',
            ],
        ]); ?>
    </div>
</section>