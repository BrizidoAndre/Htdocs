<?php

namespace app\controllers;

use app\models\Graphiccard;
use app\models\Image;
use app\models\Machine;
use app\models\Rammemory;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\rest\Controller;

class GraphiccardController extends Controller
{

    public function actionIndex($pageSize = 20)
    {

        $query = Graphiccard::find()->where(['>', 'id', '1']);

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

    public function actionSearch($name, $pageSize = 20)
    {
        $query = Graphiccard::find()->where(['=', 'name', $name]);

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