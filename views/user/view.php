<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'username',
            'name',
            'surname',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            'dob',
            'phone_no',
            'Address',
            'passcode',
            'visited_on',
            'created_at',
            'type',
            'delete',
            'status',
            'update_at',
            //'created_by',
            [
                'label' => 'Created By Username',
                'value' => $model->createdBy->name,
            ],
            'remark:ntext',
        ],
    ]) ?>

</div>
