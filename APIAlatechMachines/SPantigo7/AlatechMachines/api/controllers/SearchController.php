<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Brand;
use app\models\Graphiccard;
use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\Motherboard;
use app\models\Powersupply;
use app\models\Processor;
use app\models\Rammemory;
use app\models\Storagedevice;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class SearchController extends JsonController
{


    public function actionFind($components, $pageSize = 20){

        $list = $this->getRightComponents($components);

        $data = new ActiveDataProvider([
            'pagination' => [
                'pageSize' =>  $pageSize
            ],
            'query' => $list
        ]);

        return $data;
    }

    public function actionSearch($components, $q, $pageSize = 20){
        $list = $this->getRightComponents($components, $q);

        $data = new ActiveDataProvider([
            'pagination' => [
                'pageSize' =>  $pageSize
            ],
            'query' => $list
        ]);

        return $data;
    }


    function getRightComponents($component, $name=null){


        switch ($component){
            case 'motherboards':
                return $name === null ? Motherboard::find() : Motherboard::find()->where(['name' => $name]);
            case 'processors':
                return $name === null ? Processor::find() : Processor::find()->where(['name' => $name]);
            case 'ram-memories':
                return $name === null ? Rammemory::find() : Rammemory::find()->where(['name' => $name]);
            case 'storage-devices':
                return $name === null ? Storagedevice::find() : Storagedevice::find()->where(['name' => $name]);
            case 'graphic-cards':
                return $name ===null ? Graphiccard::find() : Graphiccard::find()->where(['name' => $name]);
            case 'power-supplies':
                return $name ===null ? Powersupply::find() : Powersupply::find()->where(['name' => $name]);
            case 'machines':
                return $name ===null ? Machine::find() : Machine::find()->where(['LIKE', 'name', $name]);
            case 'brands':
                return $name ===null ? Brand::find() : Brand::find()->where(['name' => $name]);
            default:
                throw new NotFoundHttpException();

        }
    }
}