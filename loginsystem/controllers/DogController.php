<?php

namespace app\controllers;

use app\models\Dog;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\JsonResponseFormatter;

class DogController extends Controller
{
    public function actionIndex()
    {
        return Dog::find()->all();
    }

    public function actionPower(){
        return Dog::find()->where(['>','id', 2])->all();
    }

    public function actionView($id){
        return Dog::findOne($id);
    }

    public function behaviors()
    {


        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class
                ]
            ]
        ];
    }
}