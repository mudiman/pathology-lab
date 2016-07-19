<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\controllers\BaseController;



class SiteController extends BaseController
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $session = Yii::$app->session;
        if ($session['type'] == "user") {
            return $this->render('dashboard');
        }else {
            return $this->render('index');
        }
    }

    public function actionLogin()
    {
        $session = Yii::$app->session;
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!isset($session['username'])){

            $model = new LoginForm(['scenario' => 'userlogin']);
            if ($model->load(Yii::$app->request->post()) && $model->login()) {

                $session['type']= $model->getUser()->getType();
                $session['user_id']= $model->getUser()->getId();
                $session['username'] = $model->getUser()->getUserName();

            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }
        if ($session['type'] == "user") {
            return $this->render('dashboard');
        } else {

            return $this->render('dashboardpatient');

        }

    }

    public function actionPatientLogin($username)
    {
        $session = Yii::$app->session;

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!isset($session['username'])){

            $model = new LoginForm(['scenario' => 'patientlogin']);
            $model->username=$username;
            if ($model->load(Yii::$app->request->post()) && $model->login()) {

                $session['type']= $model->getUser()->getType();
                $session['user_id']= $model->getUser()->getId();
                $session['username'] = $model->getUser()->getUserName();

            } else {
                return $this->render('loginpatient', [
                    'model' => $model,
                ]);
            }
        }
        return $this->render('dashboardpatient');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $session = Yii::$app->session;
        $session->close();
        $session->destroy();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
