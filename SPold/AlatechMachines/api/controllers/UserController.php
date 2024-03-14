<?php

namespace app\controllers;

use app\models\User;
use yii\rest\Controller;

class UserController extends Controller
{

    public function actionSignin()
    {
        $user = new User();

        if ($user->load(\Yii::$app->request->getBodyParams(), '')) {

            $user->password = hash_hmac('sha256', $user->password, '');

            if ($user->save()) {
                return [
                    'Usuário cadastrado com sucesso'
                ];
            }
            return $user;
        }

        return 'Parametros incorretos';
    }

    public function actionLogin()
    {
        $user = new User();

        $user->load(\Yii::$app->request->getBodyParams(), '');


        $user = User::find()->where(['username' => $user->username])->andWhere(['password' => hash_hmac('sha256',$user->password,'')])->one();

        if ($user) {

            $user->generateToken();

            $user->save();

            return [
                'token' => $user->accessToken
            ];
        }
        return [
            'message' => 'Credenciais inválidas'
        ];
    }


    public function actionLogout(){
        $token = \Yii::$app->request->headers->get('authorization');

        $token = explode(' ', $token)[1];

        $user = User::findIdentityByAccessToken($token);

        if($user){
           $user->accessToken = null;
           $user->save();
           return [
               'message' => 'Logout com sucesso'
           ];
        }

        return'';
    }

}