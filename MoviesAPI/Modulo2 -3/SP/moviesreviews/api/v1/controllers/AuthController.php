<?php

namespace app\controllers;

use app\models\Accesstoken;
use app\models\User;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function actionSignup()
    {

        $newUser = new User();

        if ($newUser->load(\Yii::$app->request->getBodyParams(), '')) {

            if (!$newUser->validate()) {
                \Yii::$app->response->setStatusCode(422);
                return [
                    'message' => "Invalid properties",
                    'errors' => $newUser->errors
                ];
            }


            if ($newUser->save()) {
                $newToken = new Accesstoken();

                $newToken->userId = $newUser->id;
                $newToken->creationDate = date('Y-m-d H:i:s');
                $newToken->tokenString = $newUser->generateToken();

                $newToken->save();

                \Yii::$app->response->setStatusCode(201);
                return [
                    'token' => $newToken->tokenString
                ];

            }

            return $newUser;
        }
    }


    public function actionSignout()
    {
        $user = \Yii::$app->user->identity;
        Accesstoken::deleteAll(['userId' => $user->id]);

        \Yii::$app->response->setStatusCode(204);
        return;
    }


    public function actionSignin()
    {
        $findedUser = new User();
        $findedUser->setScenario(User::SCENARIO_LOGIN);

        if ($findedUser->load(\Yii::$app->request->getBodyParams(), '')) {


            if (!$findedUser->validate()) {
                \Yii::$app->response->statusCode = 422;
                return [
                    'message' => 'Invalid properties',
                    'errors' => $findedUser->errors
                ];
            }

            $userSearchRaw = User::find()->andWhere(['email' => $findedUser->email])
                ->andWhere(['password' => $findedUser->password])->one();

            if($userSearchRaw){
                $userSearchRaw->password = hash_hmac('sha256', $userSearchRaw->password, '');
                $userSearchRaw->save();

                $newToken = new Accesstoken();

                $newToken->userId = $userSearchRaw->id;
                $newToken->creationDate = date('Y-m-d H:i:s');
                $newToken->tokenString = $userSearchRaw->generateToken();

                $newToken->save();

                return [
                    'message' => $newToken->tokenString
                ];
            }

            $userSearch = User::find()->andWhere(['email' => $findedUser->email])
                ->andWhere(['password' => hash_hmac('sha256', $findedUser->password, '')])->one();

            if($userSearch){
                $newToken = new Accesstoken();

                $newToken->userId = $userSearch->id;
                $newToken->creationDate = date('Y-m-d H:i:s');
                $newToken->tokenString = $userSearch->generateToken();

                $newToken->save();

                return [
                    'message' => $newToken->tokenString
                ];
            }


            \Yii::$app->response->statusCode = 422;
            return [
                'message' => 'Invalid email or password'
            ];

        }
    }
}