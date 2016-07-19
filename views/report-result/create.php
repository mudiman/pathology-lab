<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReportResult */

$this->title = 'Create Report Result';
$this->params['breadcrumbs'][] = ['label' => 'Report Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-result-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tests' => $tests,
        'reportid'=>$reportid,
        'templateid' => $templateid,
    ]) ?>

</div>
