<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Challans */

$this->title = $model->c_id;
$this->params['breadcrumbs'][] = ['label' => 'Challans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="challans-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->c_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->c_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'c_id',
            'challan_number',
            'customer_id',
            'amount',
            'challan_date',
            'description',
            'is_merged',
            'is_billed',
            'billing_date',
        ],
    ]) ?>

</div>
