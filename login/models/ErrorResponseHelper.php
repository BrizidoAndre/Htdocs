<?php

namespace app\models;

class ErrorResponseHelper
{
    public static function beforeResponseSend(\yii\base\Event $event)
    {
        /**
         * @var \yii\web\Response $response
         */
        $response = $event->sender;
        if ($response->statusCode === 401) {

            if (\Yii::$app->request->headers->get('authorization')) {
                \Yii::$app->response->statusCode = 403;
                $response->data = [
                    'message' => 'Token inválido'
                ];
            } else {
                $response->data = [
                    'message' => 'Usuário não autenticado',
                ];
            }
        }
    }

}