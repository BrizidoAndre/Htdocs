<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ImageController extends Controller
{
    public function actionIndex($id){

//        creating two path, one for PNG and one for JPG
        $imagePathPng = \Yii::getAlias('@webroot') . '/images/' . $id . '.png';
        $imagePathJpg = \Yii::getAlias('@webroot') . '/images/' . $id . '.jpg';

        if(file_exists($imagePathPng)){
            \Yii::$app->response->headers->set('Content-type', ['image/png']);
            \Yii::$app->response->format = Response::FORMAT_RAW;

            \Yii::$app->response->data = file_get_contents($imagePathPng);
            return;
        }
        else if(file_exists($imagePathJpg)){
            \Yii::$app->response->headers->set('Content-type', ['image/jpg']);
            \Yii::$app->response->format = Response::FORMAT_RAW;

            \Yii::$app->response->data = file_get_contents($imagePathJpg);
            return;
        }

        //if it doesn't exist then returns a Not Found
        throw new NotFoundHttpException('Imagem não encontrada');
    }
}