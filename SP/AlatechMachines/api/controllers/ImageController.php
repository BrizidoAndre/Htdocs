<?php

namespace app\controllers;

use yii\db\Exception;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ImageController extends Controller
{
    public function actionIndex($id)
    {
        try {
            $imagePathPng = \Yii::getAlias('@webroot') . '/images/' . $id . '.png';
            $imagePathJpg = \Yii::getAlias('@webroot') . '/images/' . $id . '.jpg';

            if (file_exists($imagePathPng)) {
                $image = file_get_contents($imagePathPng);
                \Yii::$app->response->format = 'raw';
                \Yii::$app->response->headers->set('Content-Type', 'image/png');
                return $image;
            }
            if (file_exists($imagePathJpg)) {
                $image = file_get_contents($imagePathJpg);
                \Yii::$app->response->format = 'raw';
                \Yii::$app->response->headers->set('Content-Type', 'image/jpeg');
                return $image;
            }

            throw new NotFoundHttpException('Imagem não encontrada');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}