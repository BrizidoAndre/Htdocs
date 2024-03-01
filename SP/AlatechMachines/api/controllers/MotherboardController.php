<?php

namespace app\controllers;

use app\models\Motherboard;
use yii\rest\Controller;

class MotherboardController extends Controller
{

    public function actionIndex(){
        return Motherboard::find()->all();
    }

    public function behaviors()
    {
        return [];
    }
}