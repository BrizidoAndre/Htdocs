<?php

namespace app\controllers;

use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;
use yii\rest\Controller;
use yii\web\Response;

class ImageController extends Controller
{


    public function actionIndex($id){

        $pngPath = \Yii::getAlias('@webroot') . '/images/' . $id . '.png';
        $jpgPath = \Yii::getAlias('@webroot') . '/images/' . $id . '.jpg';

        if(file_exists($pngPath)){
            $image = file_get_contents($pngPath);
            \Yii::$app->response->format = Response::FORMAT_RAW;
            \Yii::$app->response->headers->set('Content-Type', 'image/png');
            \Yii::$app->response->data = $image;
            return \Yii::$app->response->data;
        }
        if(file_exists($jpgPath)){
            $image = file_get_contents($jpgPath);
            \Yii::$app->response->format = Response::FORMAT_RAW;
            \Yii::$app->response->headers->set('Content-Type', 'image/jpg');
            \Yii::$app->response->data = $image;
            return \Yii::$app->response->data;
        }

        return \Yii::getAlias('@webroot');
    }
}