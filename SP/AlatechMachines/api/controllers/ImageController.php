<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\web\Response;

class ImageController extends Controller
{
    public function actionImage($id)
    {
        $response = \Yii::$app->response;

        $png = $id . '.png';
        $jpg = $id . '.jpg';


        $imagePng = \Yii::getAlias('@webroot/images/' . $png);
        $imageJpg = \Yii::getAlias('@webroot/images/' . $jpg);


        if (file_exists($imagePng)) {
            $response->headers->add('content-type', 'image/png');

            $response->data = file_get_contents($imagePng);


            $response->format = Response::FORMAT_RAW;
            return $response;
        } else if (file_exists($imageJpg)) {

            $response->headers->add('content-type', 'image/jpeg');

            $response->data = file_get_contents($imageJpg);


            $response->format = Response::FORMAT_RAW;
            return $response;

        } else {

            $response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Imagem não encontrada'
            ];
        }
    }

    public function actionType()
    {
        $image = \Yii::$app->request->getBodyParams();

        $pureImage = base64_decode($image['image64']);

        return imagecreatefrompng('sdagf');

        return exif_imagetype($pureImage);
    }

}