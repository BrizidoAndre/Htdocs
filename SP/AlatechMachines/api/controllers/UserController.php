<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UnprocessableEntityHttpException;

class UserController extends JsonController
{

    public function actionLogin(){
        $user = new User();

        if($user->load(\Yii::$app->request->getBodyParams(),'')){

            $userFound = User::find()->where(['username' => $user->username])->andWhere(['password' => hash_hmac('sha256',$user->password,'')])->one();

            if(!$userFound){
                throw new UnprocessableEntityHttpException('Credenciais inválidas');
            }

            if($userFound->accessToken){
                throw new ForbiddenHttpException('Usuário já autenticado');
            }

            $userFound->generateToken();

            $userFound->save();

            return [
                'token' => $userFound->accessToken
            ];
        }
        throw new BadRequestHttpException('Requisição sem corpo');
    }


    public function actionLogout(){
        $token = explode(' ', \Yii::$app->request->headers->get('authorization'))[1];


        $user = User::findIdentityByAccessToken($token);

        $user->accessToken = null;

        $user->save();

        return [
            'message' => 'Logout com sucesso'
        ];
    }

}