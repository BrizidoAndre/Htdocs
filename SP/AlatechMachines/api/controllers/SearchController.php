<?php

namespace app\controllers;

use app\models\Brand;
use app\models\Graphiccard;
use app\models\Machine;
use app\models\Motherboard;
use app\models\Powersupply;
use app\models\Processor;
use app\models\Rammemory;
use app\models\Storagedevice;
use yii\rest\Controller;
use yii\web\Response;

class SearchController extends Controller
{
    public function actionIndex(){
        $category = \Yii::$app->request->get('category');

        \Yii::$app->response->format = Response::FORMAT_JSON;

        switch ($category){
            case 'motherboards':
                return Motherboard::find()->all();
            case 'processors':
                return Processor::find()->all();
            case 'ram-memories':
                return Rammemory::find()->all();
            case 'storage-devices':
                return Storagedevice::find()->all();
            case 'graphic-cards':
                return Graphiccard::find()->all();
            case 'power-supplies':
                return Powersupply::find()->all();
            case 'machines':
                return Machine::find()->all();
            case 'brands':
                return Brand::find()->all();
        }

    }

}