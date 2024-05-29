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
            throw new ForbiddenHttpException('Token inválido');
        }

        throw new UnauthorizedHttpException('Necessário estar autenticado no sistema');

    }

}