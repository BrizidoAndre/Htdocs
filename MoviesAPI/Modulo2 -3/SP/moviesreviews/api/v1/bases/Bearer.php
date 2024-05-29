<?php

namespace app\bases;

use yii\db\Exception;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class Bearer extends HttpBearerAuth
{
    public function handleFailure($action)
    {
        $token  = \Yii::$app->request->headers->get('authorization');

        if($token){
            throw new ForbiddenHttpException("Invalid token");
        }

        throw new UnauthorizedHttpException('Unauthenticated user');
    }
}