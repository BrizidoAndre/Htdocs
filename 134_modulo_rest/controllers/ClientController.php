<?php

namespace app\controllers;

use app\bases\RestController;
use app\models\Users;
use http\Client;

class ClientController extends RestController
{
    public function actionIndex()
    {
        $client = new Users();
        $client->load(\Yii::$app->request->getBodyParams(),'');

        $client->token = \Yii::$app->security->generateRandomString(15);

        if(!$client->save()){
            $this->setStatus(422);
            return [
                'message' => 'Erro verifique os dados'
            ];
        }
        return [
            'message' => 'Cliente cadastrado com sucesso!'
        ];
    }

    public function actionGet($cnpj)
    {
        $client = Users::findOne(['cnpj' => $cnpj]);

        if(!$client){
            return [
                'message' => 'Cliente não encontrado'
            ];
        }
        return $client;
    }

    public function actionCarrier()
    {
        $client = new Users();
        $client->load(\Yii::$app->request->getBodyParams(),'');

        $client->token = \Yii::$app->security->generateRandomString(15);
        $client->transportadora = true;

        if(!$client->save()){
            $this->setStatus(422);
            return [
                'message' => 'Erro verifique os dados'
            ];
        }
        return [
            'message' => 'Transportador cadastrado com sucesso!'
        ];
    }

    public function actionGetClients($cnpj)
    {
        $transporter = Users::findOne(['cnpj' => $cnpj]);

        if(!$transporter){
            return [
                'message' => 'Transportador não foi encontrado'
            ];
        }

        return [
            'clientes' => Users::findAll(['transportadora' => 0])
        ];
    }
}