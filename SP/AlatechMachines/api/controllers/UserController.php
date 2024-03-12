<?php

namespace app\controllers;

use app\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class UserController extends Controller
{

    public function actionLogin(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userSearch = \Yii::$app->request->getBodyParams();

        $user = User::find()->andWhere(['=','username', $userSearch['username']])->andWhere(['=','password',$userSearch['password']])->one();


        if($user === null){
            \Yii::$app->response->statusCode = 422;
            return[
                'message'=>'Credenciais Inválidas'
            ];
        }

        if($user->accessToken==="null"){
            \Yii::$app->response->statusCode = 403;
            return[
                'message'=>'Usuário já autenticado'
            ];
        }

        else{
            $user->accessToken = $user->GenerateToken();
            $user->save();
        }
        return [
            'token' => $user->accessToken,
        ];

    }





}