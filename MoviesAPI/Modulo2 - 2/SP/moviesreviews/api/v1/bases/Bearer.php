<?php

namespace app\bases;

use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class Bearer extends HttpBearerAuth
{
    public function handleFailure($response)
    {
        $header = \Yii::$app->request->headers->get('authorization');

        if($header){
            throw new ForbiddenHttpException('Invalid token');
        }
        throw new UnauthorizedHttpException('Unauthenticated user');
    }
}