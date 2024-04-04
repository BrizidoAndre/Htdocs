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

class SearchController extends JsonController
{
    public function actionIndex($category, $pageSize = 20)
    {
        try {
            $category = \Yii::$app->request->get('category');

            $list = $this->getRight($category);

            $orderedList = new ActiveDataProvider();

            $orderedList->pagination->pageSize = $pageSize;
            $orderedList->query = $list;

            return $orderedList;


        } catch (\ErrorException $e) {
            return $e->getMessage();
        }
    }

    public function actionSearch($q, $pageSize = 20)
    {
        $category= \Yii::$app->request->get('category');

        $list = $this->getRight($category, true, $q);

        $orderedList = new ActiveDataProvider();

        $orderedList->pagination->pageSize = $pageSize;
        $orderedList->query = $list;

        return $orderedList;
    }

    function getRight($key, $hasName=false, $name=null)
    {
        switch ($key) {
            case'motherboards':
                return ($hasName ? Motherboard::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case 'processors':
                return ($hasName ? Processor::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case 'ram-memories':
                return ($hasName ? Rammemory::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case'storage-devices':
                return ($hasName ? Storagedevice::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case'graphic-cards':
                return ($hasName ? Graphiccard::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case'power-supplies':
                return ($hasName ? Powersupply::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
            case'machines':
                return ($hasName ? Machine::find()->where(['LIKE', 'name', $name]) : Motherboard::find());
        }
    }

}