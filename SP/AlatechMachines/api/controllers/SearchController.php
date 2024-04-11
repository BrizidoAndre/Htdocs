<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\Graphiccard;
use app\models\Machine;
use app\models\Motherboard;
use app\models\Powersupply;
use app\models\Processor;
use app\models\Rammemory;
use app\models\Storagedevice;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class SearchController extends JsonController
{
    public function actionIndex($category, $pageSize = 20)
    {
        try {
            $list = $this->getRight($category);

            if($list === 'error'){
                throw new NotFoundHttpException('Página não encontrada');
            }

            $orderedList = new ActiveDataProvider([
                'query' => $list,
                'pagination' => [
                    'pageSize' => $pageSize
                ]
            ]);

            return $orderedList->getModels();


        } catch (\ErrorException $e) {
            return $e->getMessage();
        }
    }

    public function actionSearch($category, $q, $pageSize = 20)
    {

        $list = $this->getRight($category, true, $q);

        if($list === 'error'){
            throw new NotFoundHttpException('Página não encontrada');
        }

        $orderedList = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

        return $orderedList;
    }

    function getRight($key, $hasName=false, $name=null)
    {
        switch ($key) {
            case'motherboards':
                return ($hasName ? Motherboard::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case 'processors':
                return ($hasName ? Processor::find()->where(['LIKE', 'name', $name]) : Processor::find());
            case 'ram-memories':
                return ($hasName ? Rammemory::find()->where(['LIKE', 'name', $name]) : Rammemory::find());
            case'storage-devices':
                return ($hasName ? Storagedevice::find()->where(['LIKE', 'name', $name]) : Storagedevice::find());
            case'graphic-cards':
                return ($hasName ? Graphiccard::find()->where(['LIKE', 'name', $name]) : Graphiccard::find());
            case'power-supplies':
                return ($hasName ? Powersupply::find()->where(['LIKE', 'name', $name]) : Powersupply::find());
            case'machines':
                return ($hasName ? Machine::find()->where(['LIKE', 'name', $name]) : Machine::find());
            default:
               return 'error';
        }
    }

}