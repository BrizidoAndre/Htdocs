<?php

namespace app\controllers;
http://localhost/react_auth/auth/teste

use app\bases\Bearer;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\JsonParser;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        unset($behaviors['contentNegotiator']['formats']['application/xml']);
        $behaviors['cors'] = [
            'class' => Cors::class
        ];
        $behaviors['authenticator'] = [
            'class' => Bearer::class,
        ];
        return $behaviors;
    }

    public function actionTeste($url)
    {
        return \Yii::$app->formatter->asCurrency(202000.2);
    }
}