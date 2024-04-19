<?php

namespace app\bases;

use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class BearerBase extends HttpBearerAuth
{
    public function handleFailure($response)
    {
        $header = \Yii::$app->request->headers->get('authorization');

        if($header){
            throw new ForbiddenHttpException('Token inválido');
        }

        throw new UnauthorizedHttpException("Necessário estar autenticado no sistema");
    }

}