<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MediaController extends Controller
{
    public function actionIndex($mediaId)
    {

        $jpgPath = \Yii::getAlias('@webroot') . '/media/' . $mediaId . '.jpg';
        $mp4Path = \Yii::getAlias('@webroot') . '/media/' . $mediaId . '.mp4';

        if (file_exists($jpgPath)) {
            \Yii::$app->response->data = file_get_contents($jpgPath);
            \Yii::$app->response->format = Response::FORMAT_RAW;
            \Yii::$app->response->headers->set('Content-Type', 'image/jpeg');

            return \Yii::$app->response->data;
        }

        if (file_exists($mp4Path)) {
            \Yii::$app->response->data = file_get_contents($mp4Path);
            \Yii::$app->response->format = Response::FORMAT_RAW;
            \Yii::$app->response->headers->set('Content-Type', 'video/mp4');

            return \Yii::$app->response->data;
        }
        else{
            throw new NotFoundHttpException('Could not find any file with the id ' . $mediaId);
        }


    }
}