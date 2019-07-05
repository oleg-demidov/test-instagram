<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ProfileController extends Controller
{
    
    
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
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        return $this->render('index', [
            'oUser' => Yii::$app->user->identity,
        ]);
    }
    
    

}
