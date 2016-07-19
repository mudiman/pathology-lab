<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReportTemplate */

$this->title = 'Create Report Template';
$this->params['breadcrumbs'][] = ['label' => 'Report Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
