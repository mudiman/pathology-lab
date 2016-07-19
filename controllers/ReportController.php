<?php

namespace app\controllers;

use app\models\ReportTemplate;
use Yii;
use app\models\Report;
use app\models\ReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use yii\data\SqlDataProvider;
use mPDF;
use app\models\User;
use app\models\UserSearch;
use yii\helpers\ArrayHelper;
use app\controllers\BaseController;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends BaseController
{

    /**
     * Gets patient and report template list for dropdownlist
     * @return array
     */
    private function _getFormData()
    {

        $patientlist = ArrayHelper::map(User::find()->where(['type' => 'patient'])->asArray()->all(), 'id', 'name');
        $reportTemplates = ArrayHelper::map(ReportTemplate::find()->asArray()->all(), 'id', 'name');

        return [$patientlist,$reportTemplates];
    }

    /**
     * Check resource access
     * @param $id
     * @throws NotFoundHttpException
     */
    private function _checkResourceAccess($id)
    {
        $session = Yii::$app->session;
        // check if user has access to this report
        $thismodel =  $this->findModel($id);
        if($session['type'] != 'user' && $thismodel->patient_id != Yii::$app->user->id) {
            $this->redirect(array('index'));
            return false;
        }
        return true;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','delete','view', 'pdf', 'email'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete','create','update'],
                        'matchCallback' => function ($rule, $action) {
                            $session = Yii::$app->session;
                            return isset($session['type']) && $session['type']=='user';
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view', 'pdf', 'email'],
                        'matchCallback' => function ($rule, $action) {
                            $session = Yii::$app->session;
                            return isset($session['user_id']);
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Report models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;

        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $view = 'index';
        if ($session['type']=='patient') {
            $view = 'indexpatient';
        }

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'showcreate' => $session['type']=='user',
        ]);
    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     */
    private function _viewData($id)
    {

        $dataProvider = new SqlDataProvider([
            'sql' => 'select
t.name test,rs.result result,t.unit unit,t.reference reference
from
report r, report_result rs, test t
where
t.id=rs.test_id and rs.report_id=r.id and r.id='.(int) $id,
            //'totalCount' => $totalCount,
            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $report =  $this->findModel($id);
        $user = User::find()->where(['id' => $report->patient_id])->one();

        return [
            'model' => $report,
            'userModel' => $user,
            'dataProvider' => $dataProvider,
        ];
    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $session = Yii::$app->session;
        if (!$this->_checkResourceAccess($id)){
            return;
        }

        $view = 'view';
        if ($session['type']=='patient') {
            $view = 'viewpatient';
        }
        return $this->render($view, $this->_viewData($id));
    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id)
    {
        if (!$this->_checkResourceAccess($id)){
            return;
        }

        $content = $this->renderPartial('exportview', $this->_viewData($id));
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $mpdf->Output();

    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     */
    public function actionEmail($id)
    {
        if (!$this->_checkResourceAccess($id)){
            return;
        }

        $modelList =  $this->_viewData($id);

        $content = $this->renderPartial('exportview', $modelList);

        $report =  $modelList['model'];
        $userModel =  $modelList['userModel'];

        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $pdf_as_string = $mpdf->Output('', 'S');


        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->user->identity->getEmail())
            ->setTo($userModel->getEmail())
            ->setSubject('Please see your report')
            ->attachContent($pdf_as_string, ['fileName' => 'my-file.pdf', 'contentType' => 'application/pdf'])
            ->send();

        echo "Mail send";
    }
    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Report();

        list($patientlist,$reportlist) = $this->_getFormData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'patientlist' => $patientlist,
                'reportlist' => $reportlist,
            ]);
        }
    }

    /**
     * Updates an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;

        $session['report_id'] = $model->id;
        $session['template_id'] = $model->report_template_id;

        list($patientlist,$reportlist) = $this->_getFormData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'patientlist' => $patientlist,
                'reportlist' => $reportlist,
            ]);
        }
    }

    /**
     * Deletes an existing Report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
