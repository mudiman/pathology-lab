<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReportResult */

$this->title = $model->report_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-result-view">

    <h1><?= Html::encode($this->title)." ".$templateid ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'report_id' => $model->report_id, 'test_id' => $model->test_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'report_id' => $model->report_id, 'test_id' => $model->test_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Add more', ['create', 'report_id' => $model->report_id, 'test_id' => $model->test_id, 'templateid' => $templateid], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'report_id',
            'test_id',
            'result',
            'created_at',
            'delete',
            'created_by',
        ],
    ]) ?>

</div>
