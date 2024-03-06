<?php

namespace app\controllers;


use app\models\LoginForm;
use app\models\SignUpForm;
use app\models\User;
use yii\base\Model;
use yii\rest\Controller;

class UserController extends Controller
{


    public function actionSignUp(){

        $model = new SignUpForm();

        if($model->load(\Yii::$app->request->post(),'') and $model->register()){
            return $model->_user;
        }

        \Yii::$app->response->statusCode = 422;
        return [
            'message' => $model->errors
        ];
    }


    public function actionLogin(){
        $model = new LoginForm();

        if($model->load(\Yii::$app->request->post(), '') && $model->login()){

           $user = $model->getUser();
           $user->generateToken();

           $user->save();

           return $user;
        }

        \Yii::$app->response->statusCode = 422;
        return[
            'errors' => $model->errors
        ];
    }

    public function actionOut(){

        if (\Yii::$app->request->headers['authorization'] !== null){
            $rawToken = \Yii::$app->request->headers['authorization'];
            $token = explode(' ', $rawToken);
            $user = User::findIdentityByAccessToken($token[1]);
            if($user==null){
                \Yii::$app->response->statusCode = 403;
                return [
                    'message'=> 'token inválido'
                ];
            }
            $user->access_token = null;
            $user->save();
            return [
                'message' => 'logout realizado com sucesso'
            ];
        }
        \Yii::$app->response->statusCode = 401;
        return [
            'message' => 'Necessário estar autenticado no sistema'
        ];

    }

    public function actionHeader(){
        $header = \Yii::$app->request->headers['authorization'];
        return $header;
    }
}