<?php

namespace app\bases;

use app\models\Users;
use yii\filters\auth\HttpBearerAuth;

class Bearer extends HttpBearerAuth
{

    public function handleFailure($response)
    {
        \Yii::$app->response->data = [
            'message' => 'Acesso bloqueado, por favor informar novamente as suas credências'
        ];
    }

    public $only = [
        'os/index',
        'os/get',
        'os/delete',
        'travel/post',
        'travel/alter-status'
    ];
}