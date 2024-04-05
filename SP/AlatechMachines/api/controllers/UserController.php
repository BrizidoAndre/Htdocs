<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\User;
use Psy\Util\Json;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UnprocessableEntityHttpException;

class UserController extends JsonController
{

    public function actionSign(){
        try {
            $user = new User;

            $allUser = new User;

            if($user->load(\Yii::$app->request->getBodyParams(),'')){

               if($user->validate()){
                   $user->password = hash_hmac('sha256', $user->password, '');

                   $user->save();
                   return \Yii::$app->response->statusCode = 204;
               }

               throw new UnprocessableEntityHttpException('Cedenciais inválidas');
            }
            throw new BadRequestHttpException('Objeto inválido');

        }catch (\ErrorException $e){
            return $e->getMessage();
        }
    }


    public function actionLogin(){
        try {
            $user = new User;

            if($user->load(\Yii::$app->request->getBodyParams(),'')){

//                Encontrando um usuário com as mesmas caracteríscticas do usuário postado pelo cliente
                $findedUser = User::find()->where(['username' => $user->username])->andWhere(['password'=> hash_hmac('sha256',$user->password,'')])->one();

                if($findedUser){
                    if($findedUser->accessToken){
                        throw new ForbiddenHttpException('Usuário já autenticado');
                    }
                    $findedUser->createToken();
                    $findedUser->save();
                    return [
                        'token' => $findedUser->accessToken
                    ];
                }

                throw new UnprocessableEntityHttpException('Credenciais inválidas');
            }

            throw new BadRequestHttpException('Requisição de maneira incorreta');
        } catch(\ErrorException $e){
            return $e->getMessage();
        }
    }



    public function actionLogout(){
        try {

            $token = \Yii::$app->request->headers->get('authorization');

            $token = explode(' ',$token)[1];

            $user = User::findIdentityByAccessToken($token);

            $user->accessToken = null;

            $user->save();

            return[
                'message' => 'Logout com sucesso'
            ];
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}