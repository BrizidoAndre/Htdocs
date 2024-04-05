<?php

namespace app\Bases;

use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class BearerAuth extends HttpBearerAuth
{
    public function handleFailure($response)
    {
        $header = \Yii::$app->request->headers->get('authorization');

        if ($header) {
            throw new ForbiddenHttpException('Token inválido');
        }

        throw new UnauthorizedHttpException('Necessário estar authenticado no sistema');
    }
}