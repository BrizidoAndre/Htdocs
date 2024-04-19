<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\UnprocessableEntityHttpException;

class UserController extends JsonController
{
    public function actionIndex(){
        return 'hello';
    }


    public function actionSign(){
        $newUser = new User();


        if($newUser->load(\Yii::$app->request->getBodyParams(), '')){

            $newUser->password = hash_hmac('sha256',$newUser->password,'' );

            if($newUser->save()){
                return $newUser;
            }
        }
    }


    public function actionLogin(){
        $findUser = new User();

        if($findUser->load(\Yii::$app->request->getBodyParams(), '')){

            $findUser = User::find()->where(['username' => $findUser->username])->andWhere(['password' => hash_hmac('sha256', $findUser->password, '')])->one();

            if(!$findUser){
                throw new UnprocessableEntityHttpException('Credenciais inválidas');
            }

            if($findUser->accessToken){
                throw new ForbiddenHttpException('Usuário já autenticado');
            }

            $findUser->generateToken();

            $findUser->save();

            return [
                'token' => $findUser->accessToken
            ];

        }
    }


    public function actionLogout(){
        $token = explode(' ', \Yii::$app->request->headers->get('Authorization'))[1];


        $deleteKeyUser = User::findIdentityByAccessToken($token);

        $deleteKeyUser->accessToken = null;

        $deleteKeyUser->save();

        return [
            'message' => 'Logout com sucesso'
        ];
    }

}