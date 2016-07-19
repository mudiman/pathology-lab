<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportResult */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-result-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model);?>

    <?= $form->field($model, 'test_id')->dropDownList(
        $tests,
        ['prompt' => 'Select Test']
    ) ?>


    <?= $form->field($model, 'result')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
