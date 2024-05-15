<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Accesstoken;
use app\models\User;
use yii\web\UnprocessableEntityHttpException;

class AuthController extends JsonController
{

    public function actionSignup()
    {
        $newUser = new User();

        if ($newUser->load(\Yii::$app->request->getBodyParams(), '')) {

            if (!$newUser->validate()) {

                \Yii::$app->response->statusCode = 422;

                return [
                    'message' => "Invalid properties",
                    'errors' => $newUser->errors
                ];
            }

            $newUser->password = hash_hmac('sha256', $newUser->password, '');

            $newUser->save();

            $accessToken = new Accesstoken();

            $accessToken->createAccessToken($newUser->id);

            if ($accessToken->save()) {
                \Yii::$app->response->statusCode = 201;
                return [
                    'token' => 'token ' . $accessToken->tokenString
                ];
            }

            return $accessToken;

        }
    }


    public function actionSignout(){
        $header = explode(' ',\Yii::$app->request->headers->get('authorization'))[1];

        Accesstoken::deleteAll(['tokenString' => $header]);

        \Yii::$app->response->statusCode = 204;

        return;
    }


    public function actionSignin(){

        $userSearched = new User(['scenario' => User::SCENARIO_LOGIN]);

        if($userSearched->load(\Yii::$app->request->getBodyParams(),'')){

            if(!$userSearched->validate()){
                \Yii::$app->response->statusCode = 422;
                return $userSearched->errors;
            }

            $userFound = User::find()->where(['email' => $userSearched->email])->andWhere(['password' => $userSearched->password])->one();

            if($userFound){
                $userFound->password = hash_hmac('sha256', $userFound->password, '');
                $userFound->save();

                $accessToken = new Accesstoken();

                $accessToken->createAccessToken($userFound->id);

                if($accessToken->save()){
                    return [
                        'token' => 'token ' . $accessToken->tokenString
                    ];
                }
            }


            $userFound = User::find()->where(['email' => $userSearched->email])->andWhere(['password' => hash_hmac('sha256', $userSearched->password, '')])->one();

            if($userFound){
                $accessToken = new Accesstoken();
                $accessToken->createAccessToken($userFound->id);
                if($accessToken->save()){
                    return [
                        'token' => 'token ' . $accessToken->tokenString
                    ];
                }
            }

            throw new UnprocessableEntityHttpException('Invalid email or passowrd');
        }

    }
}