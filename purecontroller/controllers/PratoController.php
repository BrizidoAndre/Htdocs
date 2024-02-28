<?php

namespace app\controllers;

use app\models\Prato;
use app\models\PratoSearch;
use app\models\Restaurante;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PratoController implements the CRUD actions for Prato model.
 */
class PratoController extends ActiveController
{
    public $modelClass = 'app\models\Prato';

    public function behaviors()
    {

        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class
                ]
            ]
        ];
    }

}
