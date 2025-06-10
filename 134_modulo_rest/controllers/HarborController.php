<?php

namespace app\controllers;

use app\bases\RestController;
use app\models\Porto;

class HarborController extends RestController
{
    public function actionIndex()
    {
        $harbor = new Porto();
        $harbor->load(\Yii::$app->request->getBodyParams(), '');
        $harbor->status = 'operação';

        if (!$harbor->save()) {
            $this->setStatus(422);
            return [
                'message' => 'Erro no cadastro verifique os dados'
            ];
        }

        return [
            'message' => 'Cadatro realizado com sucesso'
        ];
    }

    public function actionAlterStatus()
    {
        $harbor = new Porto();
        $harbor->load(\Yii::$app->request->getBodyParams(), '');

        $harborFound = Porto::findOne(['id' => \Yii::$app->request->getBodyParam('id', null)]);

        if (!$harborFound) {
            return [
                'message' => 'Porto não encontrado'
            ];
        }
        if ($harborFound->status === 'em andamento' && $harbor->status === 'reparação') {
            return [
                'message' => 'O porto possui uma viagem a caminho. Ele não pode ter seu status alterado no momento'
            ];
        }
        $harborFound->status = $harbor->status;

        if (!$harborFound->save()) {
            return [
                'message' => 'Status inválido. Ele pode ser "reparação", "em andamento" ou "operação"'
            ];
        }

        return [
            'message' => 'Status alterado com sucesso'
        ];
    }
}