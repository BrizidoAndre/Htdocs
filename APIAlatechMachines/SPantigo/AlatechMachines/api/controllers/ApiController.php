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

class ApiController extends Controller
{

    public function actionSearch($q){
        $models = [
            'brands' => Brand::find()->where(['LIKE', 'name', $q])->all(),
            'graphiccards' => Graphiccard::find()->where(['LIKE', 'name', $q])->all(),
            'machines' => Machine::find()->where(['LIKE', 'name', $q])->all(),
            'motherboards' => Motherboard::find()->where(['LIKE', 'name', $q])->all(),
            'powersupplies' => Powersupply::find()->where(['LIKE', 'name', $q])->all(),
            'processors' => Processor::find()->where(['LIKE', 'name', $q])->all(),
            'rammemories' => Rammemory::find()->where(['LIKE', 'name', $q])->all(),
            'storagedevices' => Storagedevice::find()->where(['LIKE', 'name', $q])->all(),
        ];

        $category = \Yii::$app->request->get('category');

        return $models[$category];
    }

    public function behaviors()
    {
        return [];
    }
}