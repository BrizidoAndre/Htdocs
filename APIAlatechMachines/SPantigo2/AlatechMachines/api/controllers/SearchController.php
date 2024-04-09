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
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class SearchController extends Controller
{
    public function actionIndex($pageSize = 20){
        $models = [
            'motherboards' => Motherboard::find(),
            'processors' => Processor::find(),
            'ram-memories' => Rammemory::find(),
            'storage-devices' => Storagedevice::find(),
            'graphic-cards' => Graphiccard::find(),
            'power-supplies' => Powersupply::find(),
            'machines' => Machine::find(),
            'brands' => Brand::find(),
        ];

        $search = \Yii::$app->request->get('search');

        $query = $models[$search];

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $provider;
    }

    public function actionSearch($q, $pageSize = 20){
        $models = [
            'motherboards' => Motherboard::find()->where(['LIKE','name', $q]),
            'processors' => Processor::find()->where(['LIKE','name', $q]),
            'ram-memories' => Rammemory::find()->where(['LIKE','name', $q]),
            'storage-devices' => Storagedevice::find()->where(['LIKE','name', $q]),
            'graphic-cards' => Graphiccard::find()->where(['LIKE','name', $q]),
            'power-supplies' => Powersupply::find()->where(['LIKE','name', $q]),
            'machines' => Machine::find()->where(['LIKE','name', $q]),
            'brands' => Brand::find()->where(['LIKE','name', $q]),
        ];

        $search = \Yii::$app->request->get('category');


        $query = $models[$search];

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $provider;
    }

}