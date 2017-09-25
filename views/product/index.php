<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?><small>List of products</small></h1>
</section>
<section class="content">
    <p class="pull-right" style="margin-right: 15px">
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-xs-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => [
                'class' => 'box'
            ],
            'summaryOptions' => [
                'class' => 'box-header'
            ],
            'tableOptions' => [
                'class' => 'table table-bordered table-hover dataTable',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'product_id',
                'name',
                'description',
//                'base_price',
//                [
//                    'attribute' =>  'modified_at',
//                    'format' => ['date', 'medium']
//                ],
                [
                    'header' => 'Status',
                    'value' => function($data){
                        if($data->is_active == 1)
                            return "Active";
                        else
                            return "Inactive";
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Action'
                ],
            ],
        ]); ?>
    </div>

</section>

