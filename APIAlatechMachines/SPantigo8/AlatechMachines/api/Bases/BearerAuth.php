<?php

namespace app\Bases;

use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class BearerAuth extends HttpBearerAuth
{

    public function handleFailure($response)
    {
        if(\Yii::$app->request->headers->get('Authorization')){
            \Yii::$app->response->data = [
                'message' => 'Token inválido'
            ];
            return null;
        }

        \Yii::$app->response->data = [
            'message' => 'Token inválido'
        ];
    }

}