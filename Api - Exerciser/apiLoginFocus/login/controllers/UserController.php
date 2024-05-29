<?php

namespace app\controllers;

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;


class UserController extends Controller
{
    public function actionCadastro()
    {
        $model = \Yii::$app->request->getBodyParams();

        $user = User::findOne(['username' => $model['username']]);

        if (!$user) {
            $user = new User();
            $user->load(\Yii::$app->request->getBodyParams(), '');

            $user->password = hash_hmac('sha256', $user->password, '');

            if ($user->save()) {
                return [
                    'message' => 'Usuário cadastrado com sucesso'
                ];
            }

            return $user;
        }


        return [
            'message' => 'Já existe um usuário com esse username'
        ];
    }

    public function actionLogin()
    {
        $userSearch = new User();
        if ($userSearch->load(\Yii::$app->request->getBodyParams(), '')) {

            $user = User::find()->andWhere(['username' => $userSearch->username, 'password' => hash_hmac('sha256', $userSearch->password, '')])->one();

            if (!$user->accessToken) {
                $user->GenerateAccess();

                $user->save();


                return [
                    'token' => $user->accessToken
                ];
            }

            return [
                'message' => 'Usuário já cadastrado'
            ];

        }

        \Yii::$app->response->statusCode = 422;
        return [
            'message' => 'Credenciais inválidas'
        ];
    }

    public function actionLogout()
    {
        $access = \Yii::$app->request->headers->get('authorization');

        $access = explode(' ', $access)[1];


        $user = User::findOne(['accessToken' => $access]);

        if(!$user){
            return [
                'message' => 'Token inválido'
            ];
        }

        $user->accessToken = null;

        if($user->save()){
            return [
                'message' => 'Usuário deslogado com sucesso'
            ];
        }

        return [
            'message' => 'Erro inesperado'
        ];
    }

    public function actionListar(){
        return User::find()->all();
    }


}