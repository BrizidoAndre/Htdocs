<?php

namespace app\bases;

use yii\filters\auth\HttpBearerAuth;

class Bearer extends HttpBearerAuth
{

    public function handleFailure($response)
    {
        \Yii::$app->response->data = [
            'message' => 'Erro'
        ];
    }
    public $only = [
        'bananas'
    ];
}