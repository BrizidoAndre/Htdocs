<?php


namespace app\controllers;

use app\Bases\JsonController;
use app\models\Brand;
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

    public function actionSearch($component, $pageSize = 20)
    {

        $query = $this->verifyComponent($component);

        return new ActiveDataProvider([
            "query" => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

    }

    public function actionName($component, $q, $pageSize = 20)
    {

        $query = $this->verifyComponent($component, $q);

        return new ActiveDataProvider([
            "query" => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

    }


//    method for verifyng if the components is right and return a list to the pre-determined component
    function verifyComponent($component, $name = null)
    {
        switch ($component) {
            case'motherboards':
                return $name ? Motherboard::find()->where(['LIKE', 'name', $name]) : Motherboard::find();
            case'processors':
                return $name ? Processor::find()->where(['LIKE', 'name', $name]) : Processor::find();
            case'ram-memories':
                return $name ? Rammemory::find()->where(['LIKE', 'name', $name]) : Rammemory::find();
            case'storage-devices':
                return $name ? Storagedevice::find()->where(['LIKE', 'name', $name]) : Storagedevice::find();
            case'graphic-cards':
                return $name ? Graphiccard::find()->where(['LIKE', 'name', $name]) : Graphiccard::find();
            case'power-supplies':
                return $name ? Powersupply::find()->where(['LIKE', 'name', $name]) : Powersupply::find();
            case'machines':
                return $name ? Machine::find()->where(['LIKE', 'name', $name]) : Machine::find();
            case'brands':
                return $name ? Brand::find()->where(['LIKE', 'name', $name]) : Brand::find();
            default:
                throw  new NotFoundHttpException();
        }
    }
}