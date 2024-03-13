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
use yii\base\Response;
use yii\rest\Controller;
use function PHPUnit\Framework\isNull;

class ImageController extends Controller
{

    public function actionFind($id)
    {
        $image = Motherboard::find()->where(['=', 'imageUrl', $id])->one();
        if (is_null($image)) {
            $image = Processor::find()->where(['=', 'imageUrl', $id])->one();
        }
        if (is_null($image)) {
            $image = Rammemory::find()->where(['=', 'imageUrl', $id])->one();
        }
        if (is_null($image)) {
            $image = Powersupply::find()->where(['=', 'imageUrl', $id])->one();
        }
        if (is_null($image)) {
            $image = Machine::find()->where(['=', 'imageUrl', $id])->one();
        }
        if (is_null($image)) {
            $image = Graphiccard::find()->where(['=', 'imageUrl', $id])->one();
        }
        if (is_null($image)) {
            $image = Storagedevice::find()->where(['=', 'imageUrl', $id])->one();
        }

        if (!is_null($image)) {
            $image = $image->imageUrl . '.png';

            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_RAW;
            $response->headers->add('content-type', 'image/png');

            // Directly serve the image file
            $imagePath = \Yii::getAlias('@webroot/images/' . $image);

            $response->data = file_get_contents($imagePath);
            return $response;
        }

        return [
            'message' => 'Imagem não encontrada'
        ];
    }
}