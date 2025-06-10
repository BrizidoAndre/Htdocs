<?php

namespace app\controllers;

use app\bases\RestController;
use app\models\User;
use app\models\Users;
use yii\rest\Controller;

class AuthController extends Controller
{

    public function actionLogin()
    {
        $user = new Users();
        $user->load(\Yii::$app->request->getBodyParams(),'');
        $userFound = Users::findOne([
            'cnpj' => $user->cnpj,
            'senha' => $user->senha
        ]);
        if(!$userFound){
            return [
                'message' => 'Usuário não encontrado'
            ];
        }
        $userFound->token = \Yii::$app->security->generateRandomString(15);
        $userFound->save();
        return [
            'token' => $userFound->token
        ];
    }

    public function actionLogout()
    {
        $token = explode(' ', \Yii::$app->request->headers->get('Authorization'))[1] ?? null;
        if(!$token){
            return [
                'message' => 'Token não informado'
            ];
        }

        $user = Users::findOne(['token' => $token]);
        if(!$user){
            return [
                'message' => 'Usuário não encontrado'
            ];
        }

        $user->token = null;
        $user->save();
        return [
            'message' => 'Token deletado com sucesso'
        ];
    }


    public function actionTeste()
    {
        return $this->getBehaviors();
    }
}