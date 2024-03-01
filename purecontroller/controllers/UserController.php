<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignUpForm;
use app\models\User;
use app\models\UserSearch;
use yii\helpers\Console;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
   public function actionAddUser()
   {
       $user = new User();
       $user->load(\Yii::$app->getRequest()->getBodyParams(), '');

       $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password_hash);
       $user->access_token = \Yii::$app->security->generateRandomString(255);
       if($user->save()){
           $response = \Yii::$app->getResponse();
           $response->setStatusCode(201);
           return $response->statusCode;

       } else{
           $response = \Yii::$app->getResponse();
           $response->setStatusCode(404);
           return $response->statusCode;
       }
   }

//   método para encontrar o endereçamento do controller
   public function actionIndex()
   {
       return User::find()->all();
   }

   public function actionLogin()
   {
       $model = new LoginForm();

       if($model->load(\Yii::$app->request->post(), '') && $model->login())
       {
           return $model->getUser();
       }

       \Yii::$app->response->statusCode = 422;
       return [
           'errors' => $model->errors,
           'status code' => \Yii::$app->response->statusCode
       ];
   }


   public function actionSignup()
   {
       $model = new SignUpForm();

       if($model->load(\Yii::$app->request->post(), '') && $model->register())
       {
           return $model->_user;
       }

       \Yii::$app->response->statusCode = 422;
       return [
           'errors' => $model->errors
       ];
   }
}
