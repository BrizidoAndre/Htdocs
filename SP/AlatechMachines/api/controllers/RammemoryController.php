<?php

namespace app\controllers;

use app\models\Rammemory;
use yii\rest\Controller;

class RammemoryController extends Controller
{

    public function actionIndex(){
        return Rammemory::find()->all();
    }
}