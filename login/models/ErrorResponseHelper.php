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
            $response->data = [
                'message' => 'Usuário não autenticado',
            ];
        }
    }

}