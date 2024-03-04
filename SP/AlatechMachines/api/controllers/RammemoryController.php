<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Rammemory;
use app\models\Storagedevice;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class RammemoryController extends Controller
{

    public function actionIndex($pageSize = 20){

        $query = Rammemory::find()->where(['>','id','1']);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
        ]);


        return $provider;
    }
    public function actionSearch($name,$pageSize=20){
        $query = Rammemory::find()->where(['=', 'name', $name]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
        ]);

        return $provider;
    }


    public function behaviors()
    {
        return [
        ];
    }
}