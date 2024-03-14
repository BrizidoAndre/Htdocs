<?php

namespace app\controllers;

use yii\db\Exception;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ImageController extends Controller
{

    public function actionImage($id)
    {

        try {
            $id .= '.png';

            $imagePath = \Yii::getAlias('@webroot' . '/images/') . $id;

            if (file_exists($imagePath)) {
                $data = file_get_contents($imagePath);

                \Yii::$app->response->headers->set('Content-Type', 'image/png');

                \Yii::$app->response->format = Response::FORMAT_RAW;

                \Yii::$app->response->data = $data;
                return;
            }

            throw new NotFoundHttpException('Imagem não encontrada');
        } catch (Exception $exception) {

            throw new NotFoundHttpException('Imagem não encontrada');
        }


    }




}