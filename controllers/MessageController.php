<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\instagram\InstagramDirect;
use \app\models\Thread;

class MessageController extends Controller
{
   
    public $layout = 'message';
    
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    // разрешаем аутентифицированным пользователям
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // всё остальное по умолчанию запрещено
                ],
            ]
            
        ];
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
                
        $aThreads = Yii::$app->user->identity->getThreads()->all();
        
        return $this->render('index', [
            'oUser' => Yii::$app->user->identity,
            'aThreads' => $aThreads
        ]);
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionThread()
    {
        $oThread = Thread::findOne([
            'id' => Yii::$app->request->get('id')
        ]);
        
        return $this->render('thread', [
            'oThread' => $oThread
        ]);
    }

    public function actionUpdate() {
        \Yii::$app->queue->push(new InstagramDirect([
            'method'     => 'getThreads',
            'oUser'      => Yii::$app->user->identity
        ]));
        $this->goBack();
    }
}
