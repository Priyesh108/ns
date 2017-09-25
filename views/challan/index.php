<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChallansSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Challans';
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?><small>List of challans</small></h1>
</section>
<section class="content">
    <p class="pull-right" style="margin-right: 15px">
        <?= Html::a('Create Challan', ['create'], ['class' => 'btn btn-success']) ?>
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

                'challan_number',
                'customer_id',
                'amount',
                'challan_date',
                'description',
                'is_merged',
                'is_billed',
                'billing_date',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</section>
