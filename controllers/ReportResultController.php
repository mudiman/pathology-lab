<?php

namespace app\controllers;

use Yii;
use app\models\ReportResult;
use app\models\ReportResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\Test;
use app\controllers\BaseController;
/**
 * ReportResultController implements the CRUD actions for ReportResult model.
 */
class ReportResultController extends BaseController
{

    /**
     * Gets patient and report template list for dropdownlist
     * @return array
     */
    private function _getFormData() {

        $session = Yii::$app->session;
        $tests = ArrayHelper::map(Test::find()->where(['report_template_id' => $session['template_id']])->asArray()->all(), 'id', 'name');
        return $tests;
    }

    /**
     * Lists all ReportResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportResult model.
     * @param integer $report_id
     * @param integer $test_id
     * @return mixed
     */
    public function actionView($report_id, $test_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($report_id, $test_id),
        ]);
    }

    /**
     * Creates a new ReportResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        try {
            $model = new ReportResult();
            $tests = $this->_getFormData();

            $session = Yii::$app->session;
            $reportid = $session['report_id'];
            $templateid = $session['template_id'];

            $model->report_id = $reportid;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'report_id' => $model->report_id, 'test_id' => $model->test_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'tests' => $tests,
                    'reportid'=>$reportid,
                    'templateid' => $templateid,
                ]);
            }
        } catch (db\IntegrityExceptyion $e) {
               echo "duplicate error";
        }


    }

    /**
     * Updates an existing ReportResult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $report_id
     * @param integer $test_id
     * @return mixed
     */
    public function actionUpdate($report_id, $test_id)
    {
        $model = $this->findModel($report_id, $test_id);
        $tests = $this->_getFormData();

        $session = Yii::$app->session;
        $reportid = $session['report_id'];
        $templateid = $session['template_id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'report_id' => $model->report_id, 'test_id' => $model->test_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tests' => $tests,
                'reportid' => $reportid,
            ]);
        }
    }

    /**
     * Deletes an existing ReportResult model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $report_id
     * @param integer $test_id
     * @return mixed
     */
    public function actionDelete($report_id, $test_id)
    {
        $this->findModel($report_id, $test_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $report_id
     * @param integer $test_id
     * @return ReportResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($report_id, $test_id)
    {
        if (($model = ReportResult::findOne(['report_id' => $report_id, 'test_id' => $test_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
