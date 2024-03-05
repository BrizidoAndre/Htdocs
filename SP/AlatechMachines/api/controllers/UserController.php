<?php

namespace app\controllers;

use app\models\User;
use app\models\UserLogin\UserLogin;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\helpers\UnsetArrayValue;
use yii\rest\Controller;

class UserController extends Controller
{

    public function actionLogin()
    {
        $model = new UserLogin();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {

            $searchUser = User::findByUsername($model->username);


            if ($searchUser !== null) {


                $model->password = hash_hmac('sha256', $model->password, '');


                if ($model->password === $searchUser->password) {


                    if ($searchUser->accessToken === 'notNull') {

                        $searchUser->generateAccessToken();
                        $searchUser->save();

                        Yii::$app->response->statusCode = 200;


                        return [
                            'token' => $searchUser->accessToken
                        ];
                    }


                    Yii::$app->response->statusCode = 403;

                    return [
                        'Message' => 'Usuário já autenticado'
                    ];
                }
            }

        }

        Yii::$app->response->statusCode = 422;
        return [
            'message' => 'Credenciais Inválidas'
        ];
    }


    public
    function actionSignup()
    {
        $user = new User();

        if ($user->load(Yii::$app->getRequest()->getBodyParams(), '')) {

            if (User::findByUsername($user->username) === null) {

                $security = Yii::$app->security;
                $user->password = hash_hmac('sha256', $user->password, '');

                $user->accessToken = 'notNull';

                if ($user->save()) {
                    return [
                        'Usuario cadastrado com sucesso'
                    ];
                }

            }

            return [
                'error' => 'Não é possível cadastrar um usuário com este Username'
            ];

        }
        return [
            'error' => 'Um erro surgiu com a requisição de cadastro'
        ];
    }


    public function actionLogout()
    {
        $header = Yii::$app->request->headers['authorization'];

        if ($header !== null) {
            $header = explode(' ', $header);

            $user = User::findIdentityByAccessToken($header[1]);

            if($user !== null){
                $user->accessToken = 'notNull';
                $user->save();
                return [
                    'message' => 'Usuário deslogado com sucesso'
                ];
            }

            return [
                'message' => 'Token inválido'
            ];
        }

        return [
            'message' => 'Necessário estar autenticado no sistema'
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'logout'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

}