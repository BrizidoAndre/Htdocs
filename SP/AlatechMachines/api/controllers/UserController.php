<?php

namespace app\controllers;

use app\models\User;
use app\models\UserLogin\UserLogin;
use yii\rest\Controller;
use yii\web\UserEvent;

class UserController extends Controller
{
    public function actionLogin()
    {

    }


    public function actionSignup()
    {
        $user = new User();

        if ($user->load(\Yii::$app->getRequest()->getBodyParams(), '')) {

            if (User::findByUsername($user->username) === null) {

                $security = \Yii::$app->security;
                $user->password = hash_hmac('sha256', $user->password, '');

                $user->accessToken = 'notNull';

                if ($user->save()) {
                    return [
                        'Usuario cadastrado com sucesso'
                    ];
                }

            }

            return [
                'error' => 'Não é possível cadastrar um usuário com este Username'
            ];

        }
    }
}