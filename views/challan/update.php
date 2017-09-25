<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Challans */

$this->title = 'Update Challans: ' . $model->c_id;
$this->params['breadcrumbs'][] = ['label' => 'Challans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->c_id, 'url' => ['view', 'id' => $model->c_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="challans-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
