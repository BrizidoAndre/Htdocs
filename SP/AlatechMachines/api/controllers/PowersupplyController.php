<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Powersupply;
use app\models\Rammemory;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class PowersupplyController extends Controller
{
    public function actionIndex($pageSize = 20){

        $query = Powersupply::find()->where(['>','id','1']);

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
        $query = Powersupply::find()->where(['=', 'name', $name]);

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