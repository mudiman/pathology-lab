<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportResult */

$this->title = 'Update Report Result: ' . ' ' . $model->report_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->report_id, 'url' => ['view', 'report_id' => $model->report_id, 'test_id' => $model->test_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-result-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tests' => $tests,
        'reportid'=>$reportid,
    ]) ?>

</div>
