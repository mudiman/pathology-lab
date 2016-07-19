<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model);?>


    <?= $form->field($model, 'patient_id')->dropDownList(
        $patientlist,
        ['prompt' => 'Select Patient']
    ) ?>


    <?= $form->field($model, 'report_template_id')->dropDownList(
        $reportlist,
        ['prompt' => 'Select Report Template']
    ) ?>


    <?= $form->field($model, 'result_at')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Select Result time ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss',
            'todayHighlight' => true,
            'todayBtn' => true,
        ]
    ]);
    ?>

    <?= $form->field($model, 'doctor_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
