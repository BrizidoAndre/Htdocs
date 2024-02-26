<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class DefaultController extends ActiveController
{
    public $modelClass = 'app\models\Video';

    public function fields()
    {
        return ['title', 'description', 'uploaded_at'];
    }
}
