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

class ListController extends JsonController
{

    public function actionList($component, $pageSize = 20){

        $query = $this->listRightModal($component);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);
    }

    public function actionName($component, $q, $pageSize = 20){
        $query = $this->listRightModal($component, true, $q);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);
    }


//    method for search the right modals using the url as parameter
    function listRightModal($key, $haveName=false, $name=''){
        switch ($key){
            case 'motherboards':
                return $haveName ? Motherboard::find()->where(['LIKE', 'name', $name]) : Motherboard::find();
            case 'processors':
                return $haveName ? Processor::find()->where(['LIKE', 'name', $name]) : Processor::find();
            case 'ram-memories':
                return $haveName ? Rammemory::find()->where(['LIKE', 'name', $name]) : Rammemory::find();
            case 'storage-devices':
                return $haveName ? Storagedevice::find()->where(['LIKE', 'name', $name]) : Storagedevice::find();
            case 'graphic-cards':
                return $haveName ? Graphiccard::find()->where(['LIKE', 'name', $name]) : Graphiccard::find();
            case 'power-supplies':
                return $haveName ? Powersupply::find()->where(['LIKE', 'name', $name]) : Powersupply::find();
            case 'machines':
                return $haveName ? Machine::find()->where(['LIKE', 'name', $name]) : Machine::find();
            case 'brands':
                return Brand::find();
            default:
                throw new NotFoundHttpException();
        }
    }
}