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
use Symfony\Component\VarDumper\Cloner\Data;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
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
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => [
                        'POST',
                        'PUT',
                        'GET',
                        'DELETE',

                    ],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => false,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['*'],
                ],

            ],
        ];
    }

}