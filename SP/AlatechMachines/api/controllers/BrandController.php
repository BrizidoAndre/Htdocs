<?php

namespace app\controllers;

use app\models\Brand;
use yii\rest\Controller;

class BrandController extends Controller
{

    public function actionIndex(){

        return Brand::find()->all();
    }


    public function behaviors()
    {
        return [

        ];
    }
}