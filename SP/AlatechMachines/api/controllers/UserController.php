<?php

namespace app\controllers;

use app\models\User;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class UserController extends Controller
{

    public function actionSign()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $user = new User();

        $model = \Yii::$app->request->getBodyParams();

        $user->username = $model['username'];
        $user->password = $model['password'];

        $user->password = hash_hmac('sha256', $user->password, '');


        if ($user->save()) {
            return [
                'message' => 'Usuario salvo'
            ];
        }

        return $user;
    }

    public function actionLogin()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = \Yii::$app->request->getBodyParams();

        $user = User::find()->where(['username' => $model['username']])->andWhere(['password' => hash_hmac('sha256', $model['password'], '')])->one();

        if ($user) {

            if ($user->accessToken) {
                throw new ForbiddenHttpException('Usuário já autenticado');
            }

            $user->generateToken();
            if ($user->save()) {
                return [
                    'token' => $user->accessToken
                ];
            }

        }


        throw new UnprocessableEntityHttpException('Credenciais inválidas');
    }


    public function actionLogout(){
        \Yii::$app->response->format = Response::FORMAT_JSON;

//        Obtendo o token através do header
        $token = \Yii::$app->request->headers->get('authorization');

        $token  = explode(' ', $token)[1];

        $user = User::findIdentityByAccessToken($token);

        if($user){
            $user->accessToken = null;
            $user->save();

            \Yii::$app->response->statusCode = 204;
            return '';
        }
    }


    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => [
                        '*',
                    ],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'POST',
                        'PUT',
                        'PATCH',
                        'DELETE',
                        'HEAD',
                        'OPTIONS',
                    ],
                    'Access-Control-Request-Headers' => [
                        '*',
                    ],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Allow-Origin' => [
                        '*',
                    ],
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }
}