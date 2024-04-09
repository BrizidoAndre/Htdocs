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
            $imagePNG = $id . '.png';

            $imageJPG = $id . '.jpg';

            $imagePNG = \Yii::getAlias('@webroot' . '/images/') . $imagePNG;
            $imageJPG = \Yii::getAlias('@webroot' . '/images/') . $imageJPG;

            if (file_exists($imagePNG)) {
                $data = file_get_contents($imagePNG);


                \Yii::$app->response->headers->set('Content-Type', 'image/png');

                \Yii::$app->response->format = Response::FORMAT_RAW;

                \Yii::$app->response->data = $data;
                return;
            } else if (file_exists($imageJPG)) {
                $data = file_get_contents($imageJPG);

                \Yii::$app->response->headers->set('Content-Type', 'image/jpeg');
                \Yii::$app->response->format = Response::FORMAT_RAW;

                \Yii::$app->response->data = $data;
                return;
            } else {
                throw new NotFoundHttpException('Imagem não encontrada');
            }
        } catch (Exception $exception) {

            throw new NotFoundHttpException('Imagem não encontrada');
        }


    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => [
                        '*',
                    ],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'POST',
                        'PUT',
                        'PATCH',
                        'DELETE',
                        'HEAD',
                        'OPTIONS',
                    ],
                    'Access-Control-Request-Headers' => [
                        '*',
                    ],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Allow-Origin' => [
                        '*',
                    ],
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }


}