<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Report */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Export', ['pdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <h2>Patient Detail</h2>
    <?= DetailView::widget([
        'model' => $userModel,
        'attributes' => [
            'username',
            'age',
            'phone_no',
            'visited_on',
            'update_at',
        ],
    ]) ?>
    <h2>Report Detail</h2>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            //'delete',
            //'patient_id',
            //'report_template_id',
            [
                'label' => 'Report template Name',
                'value' => $model->reportTemplate->name,
            ],
            //'created_by',
            [
                'label' => 'Created By Username',
                'value' => $model->createdBy->name,
            ],
            'status',
            'result_at',
            'doctor_ref',
            'remarks:ntext',
        ],
    ]) ?>

    <h2>Test Detail</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'test',
            'result',
            'unit',
            'reference',

        ],
    ]); ?>

</div>
