<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ($showcreate ? Html::a('Create Report', ['create'], ['class' => 'btn btn-success']):'') ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'created_at',
            //'patient_id',
            [
                'attribute' => 'Patient Name',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div>'.$model->patient->name.'</div>';
                },
            ],
            //'report_template_id',
            [
                'attribute' => 'Report Template Name',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div>'.$model->reportTemplate->name.'</div>';
                },
            ],
            //'created_by',
            [
                'attribute' => 'Created By',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div>'.$model->createdBy->name.'</div>';
                },
            ],
            // 'delete',
            // 'status',
             'result_at',
             'doctor_ref',
             //'remarks:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{pdf}{email}',
                'buttons'=>[
                    'pdf' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [
                            'title' => Yii::t('yii', 'export'),
                        ]);

                    },
                    'email' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-envelope"></span>', $url, [
                            'title' => Yii::t('yii', 'email'),
                        ]);

                    }
                ]
            ],

        ],
    ]); ?>

</div>
