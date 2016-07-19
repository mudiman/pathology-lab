<?php
/**
 * Created by PhpStorm.
 * User: Mudassar Ali
 * Date: 6/15/2015
 * Time: 10:58 AM
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class BaseController extends Controller
{

    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view'],
                        'matchCallback' => function ($rule, $action) {
                            $session = Yii::$app->session;
                            return isset($session['user_id']);
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','create','update'],
                        'matchCallback' => function ($rule, $action) {
                            $session = Yii::$app->session;
                            return isset($session['type']) && $session['type']=='user';
                        }
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

} 