<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class DefaultController extends ActiveController
{
    public $modelClass = 'app\models\Empresa';

    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::class,

                'formats' => [

                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }

}