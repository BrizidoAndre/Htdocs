<?php

namespace app\controllers;


use app\bases\JsonController;
use app\models\User;

class UserController extends JsonController
{
    public function actionLogin()
    {

        $userSearched = new User();

        if ($userSearched->load(\Yii::$app->request->getBodyParams(), '')) {

//           comparing the user searched with its username and its crypted password
            $userFinded = User::find()->where(['username' => $userSearched->username])->andWhere(['password' => hash_hmac('sha256', $userSearched->password, '')])->one();

//            if user is not found
            if (!$userFinded) {
                \Yii::$app->response->statusCode = 422;
                return [
                    'message' => 'Credenciais inválidas'
                ];
            }

//            if user was found but access tokken is already setted
            if ($userFinded->accessToken) {
                \Yii::$app->response->statusCode = 403;
                return [
                    'message' => 'Usuário já autenticado'
                ];
            }


            if ($userFinded) {
                $userFinded->generateToken();
                $userFinded->save();
                return [
                    'token' => $userFinded->accessToken
                ];
            }
        }

        \Yii::$app->response->statusCode = 422;
        return [
            'message' => 'Credenciais inválidas'
        ];
    }

    public function actionLogout()
    {
        $token = \Yii::$app->request->headers->get('authorization');

        $token = explode(' ', $token)[1];

        $user = User::findIdentityByAccessToken($token);

        if ($user) {
            $user->accessToken = '';
            $user->save();
            return [
                'message' => 'Logout com sucesso'
            ];

        }
    }

}