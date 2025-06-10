<?php

namespace app\controllers;

use app\bases\RestController;
use app\models\Containers;
use app\models\Os;
use app\models\Users;
use app\models\Viagens;
use yii\helpers\ArrayHelper;

class OsController extends RestController
{
    public function actionIndex()
    {
//        se o usuário não for um transportador
        if (!\Yii::$app->user->identity->transportadora) {
            return [
                'Oc\'s vinculados' => Os::findAll(['id_usuario' => \Yii::$app->user->identity->id])
            ];
        }
//        se for continuar com a lógica
        $order = new Os();
        $order->load(\Yii::$app->request->getBodyParams(), '');
        $order->data_criacao = date('Y-m-d');

        $cnpj = \Yii::$app->request->getBodyParam('cnpj');
        $cnpjFromHeader = \Yii::$app->request->headers->get('Access_Client');

//        obtendo apenar o usuário com o cnpj especificado
        $userFound = array_filter(Users::find()->all(), function ($value) use ($cnpj) {
            $compare = substr($value->cnpj, 0, 6);
            return $compare === $cnpj;
        })[0] ?? null;

//        se o cnpj for diferente do header ou o não existir um usuário com o cnpj informado
        if ($cnpj !== $cnpjFromHeader || $userFound === null) {
            $this->setStatus(403);
            return [
                'message' => 'Cliente não informado não foi identificado, conferir os dados informados'
            ];
        }

        $order->id_usuario = $userFound->id;
        $order->codigo = 'OS_' . substr($userFound->cnpj, 0, 6) . date('is');
        $order->status = 'pendente';

        if (!$order->save()) {
            return [
                'message' => 'Dados inválidos'
            ];
        }

        return [
            'message' => 'Ordem de serviço cadastrado com sucesso'
        ];
    }

    public function actionGet($os_Id)
    {
//        se o usuário não for um transportador
        if (!\Yii::$app->user->identity->transportadora) {
            return [
                'Oc\'s vinculados' => Os::findAll(['id_usuario' => \Yii::$app->user->identity->id])
            ];
        }
        $os = Os::findAll($os_Id);
        if(!$os){
            return [
                'message' => 'Order não encontrada'
            ];
        }
        return $os;
    }

    public function actionDelete($os_Id)
    {
//        se o usuário não for um transportador
        if (!\Yii::$app->user->identity->transportadora) {
            return [
                'Oc\'s vinculados' => Os::findAll(['id_usuario' => \Yii::$app->user->identity->id])
            ];
        }

        $os = Os::findOne($os_Id);
        if(!$os){
            return [
                'message' => 'Order não encontrada'
            ];
        }
        Viagens::deleteAll(['id_os' => $os_Id]);
        Containers::deleteAll(['id_os' => $os_Id]);
        $os->delete();
        return [
            'message' => 'Ordem deletada com sucesso'
        ];
    }
}