<?php

namespace app\controllers;

use app\auth\BearerToken;
use app\models\Brand;
use app\models\Graphiccard;
use app\models\Machine;
use app\models\Motherboard;
use app\models\Powersupply;
use app\models\Processor;
use app\models\Rammemory;
use app\models\Storagedevice;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class SearchController extends Controller
{

    public function actionItem($pageSize = 20)
    {
        $category = \Yii::$app->request->get('category');

        switch ($category) {

            case 'motherboards':
                $query = Motherboard::find();
                break;

            case 'processors':
                $query = Processor::find();
                break;

            case 'ram-memories':
                $query = Rammemory::find();
                break;

            case 'storage-devices':
                $query = Storagedevice::find();
                break;

            case 'graphic-cards':
                $query = Graphiccard::find();
                break;

            case 'power-supplies':
                $query = Powersupply::find();
                break;

            case 'machines':
                $query = Machine::find();
                break;

            case 'brands':
                $query = Brand::find();
                break;
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        \Yii::$app->response->format = Response::FORMAT_JSON;

        return $provider;
    }

    public function actionSearch($q, $pageSize = 20)
    {

        $category = \Yii::$app->request->get('category');

        switch ($category) {
            case 'motherboards':
                $query = Motherboard::find()->where(['LIKE', 'name', $q]);
                break;
            case 'processors':
                $query = Processor::find()->where(['LIKE', 'name', $q]);
                break;
            case 'ram-memories':
                $query = Rammemory::find()->where(['LIKE', 'name', $q]);
                break;
            case 'storage-devices':
                $query = Storagedevice::find()->where(['LIKE', 'name', $q]);
                break;
            case 'graphic-cards':
                $query = Graphiccard::find()->where(['LIKE', 'name', $q]);
                break;

            case 'power-supplies':
                $query = Powersupply::find()->where(['LIKE', 'name', $q]);
                break;

            case 'machines':
                $query = Machine::find()->where(['LIKE', 'name', $q]);
                break;

            case 'brands':
                $query = Brand::find()->where(['LIKE', 'name', $q]);
                break;
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $provider;
    }
    public function behaviors()
    {

        $behaviors = parent::behaviors();

            $behaviors['corsFilter'] = [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => [
                        '*',
                    ],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'POST',
                        'PUT',
                        'PATCH',
                        'DELETE',
                        'HEAD',
                        'OPTIONS',
                    ],
                    'Access-Control-Request-Headers' => [
                        '*',
                    ],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ];

            $behaviors['verbs'] = [
                'class' => VerbFilter::class,
                'actions' => [
                    'item' => ['GET'],
                    'search' => ['GET']
                ],
            ];

//            $behaviors['access'] = [
//                'class' => BearerToken::class
//            ];

        return $behaviors;
    }
}
