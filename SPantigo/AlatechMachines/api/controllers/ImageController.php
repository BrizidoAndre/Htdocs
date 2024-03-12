<?php

namespace app\controllers;

use app\models\Graphiccard;
use app\models\Machine;
use app\models\Powersupply;
use app\models\Processor;
use app\models\Rammemory;
use app\models\Storagedevice;
use yii\rest\Controller;

class ImageController extends Controller
{
    public function actionIndex($id){

        $model = Machine::find()->where(['LIKE','imageUrl', $id])->one();
        if (is_null($model)){
            $model = Processor::find()->where(['LIKE','imageUrl', $id])->one();
        } if (is_null($model)){
            $model = Rammemory::find()->where(['LIKE','imageUrl', $id])->one();
        } if (is_null($model)){
            $model = Storagedevice::find()->where(['LIKE','imageUrl', $id])->one();
        } if (is_null($model)){
            $model = Graphiccard::find()->where(['LIKE','imageUrl', $id])->one();
        } if (is_null($model)){
            $model = Powersupply::find()->where(['LIKE','imageUrl', $id])->one();
        } if (is_null($model)){
            $model = Machine::find()->where(['LIKE','imageUrl', $id])->one();
        }

        if(is_null($model)){
            return [
                'message' => 'Imagem não encontrada'
            ];
        }
        $imageName = $model->imageUrl . '.png';

        return $imageName;
    }
}