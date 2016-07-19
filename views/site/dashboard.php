<?php
/* @var $this yii\web\View */
$this->title = 'Pathology Lab';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>What you want to do today!</h1>


    </div>

    <div class="body-content">

        <div class="row">

            <div class="col-lg-12">
                <h2>Actions</h2>

                <p>
                    <?php
                    use yii\helpers\Html;
                    use yii\helpers\Url;
                    echo Html::a(Html::tag('div',
                        Html::tag('i', '', ['class' => 'fa fa-upload fa-fw']) . 'Users/Patient list' .
                        Html::tag('span', '', ['class' => 'pull-right text-muted small'])
                    ), Url::to(['user/index']));

                    echo Html::a(Html::tag('div',
                        Html::tag('i', '', ['class' => 'fa fa-upload fa-fw']) . 'Reports list' .
                        Html::tag('span', '', ['class' => 'pull-right text-muted small'])
                    ), Url::to(['report/index']));

                    echo Html::a(Html::tag('div',
                        Html::tag('i', '', ['class' => 'fa fa-upload fa-fw']) . 'Report template list' .
                        Html::tag('span', '', ['class' => 'pull-right text-muted small'])
                    ), Url::to(['report-template/index']));

                    echo Html::a(Html::tag('div',
                        Html::tag('i', '', ['class' => 'fa fa-upload fa-fw']) . 'Test list' .
                        Html::tag('span', '', ['class' => 'pull-right text-muted small'])
                    ), Url::to(['test/index']));
                    
                    ?>
                </p>


            </div>

        </div>

    </div>
</div>