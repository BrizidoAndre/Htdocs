<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\User;

class UserController extends JsonController
{

    public function actionSign(){
        try {
            $user = new User;

            $allUser = new User;

            if($user->load(\Yii::$app->request->getBodyParams(),'')){

                $allUser->setAttributes($user->attributes);

                if($allUser->password < $allUser->accessToken){
                    return 'boa';
                }

                return $allUser;

            }
            return $user;

        }catch (\ErrorException $e){
            return $e->getMessage();
        }
    }

}