<?php

namespace app\controllers;

use app\models\Dog;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class DogController extends Controller
{
    public function actionIndex()
    {
        return Dog::find()->all();
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