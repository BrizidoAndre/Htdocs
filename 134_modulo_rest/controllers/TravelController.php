<?php

namespace app\controllers;

use app\bases\RestController;
use app\models\Os;
use app\models\Viagens;
use function Symfony\Component\String\s;

class TravelController extends RestController
{
    public function actionPost($numero_os)
    {
//        se o usuário não for um transportador
        if (!\Yii::$app->user->identity->transportadora) {
            return [
                'Oc\'s vinculados' => Os::findAll(['id_usuario' => \Yii::$app->user->identity->id])
            ];
        }

        $os = Os::findOne($numero_os);
        if (!$os) {
            return [
                'message' => 'Ordem não encontrada'
            ];
        }
        if ($os->status === 'concluído') {
            $this->setStatus(422);
            return [
                'message' => 'Não é possível alterar uma viagem já concluída'
            ];
        }
        $destiny = \Yii::$app->request->getBodyParam('portoDestino');
        $origin = \Yii::$app->request->getBodyParam('portoOrigem');
        $travels = Viagens::find()->andWhere(['id_os' => $numero_os]);
        $travels->orderBy('dataEmissao DESC');
        $lastTravel = $travels->one();

        if ($destiny === $origin || ($lastTravel && $lastTravel->portoDestino !== $origin)) {
            $this->setStatus(400);
            return [
                'message' => 'A origem/destino do porto é inconsistente com os dados do sistema'
            ];
        }

        if ($os->status === 'pendente') {
            $os->status === 'em andamento';
            $os->save();
        }

        $newTravel = new Viagens();
        $newTravel->id_os = $os->codigo;
        $newTravel->portoDestino = $destiny;
        $newTravel->portoOrigem = $origin;
        $newTravel->status = 'pendente';
        $newTravel->dataEmissao = date('Y-m-d H:i:s');
        $newTravel->save();

        $newOc = Os::findOne($numero_os);
        $viagens = $newOc->viagens;
        $viagensResult = [];
        foreach ($viagens as $viagen) {
            $viagensResult[] = [
                'portoOrigem' => [
                    'id' => $viagen->portoOrigem0->id,
                    'nome' => $viagen->portoOrigem0->name
                ],
                'portoDestino' => [
                    'id' => $viagen->portoDestino0->id,
                    'nome' => $viagen->portoDestino0->name
                ],
                'status' => $viagen->status,
                'dataEmissao' => str_replace(' ', 'T', $viagen->dataEmissao),
                'ultimaAtualizacao' => str_replace(' ', 'T', $viagen->ultimaAtualizacao)
            ];
        }
        return [
            'os' => $os->codigo,
            'cliente' => $os->usuario->cnpj,
            'porto' => $viagens[0]->id,
            'dataEmissao' => $os->data_criacao,
            'multimodal' => $viagensResult
        ];

        return [
            'message' => 'Adicionada uma viagem a ordem de serviço'
        ];
    }

    public function actionAlterStatus($numero_os, $id_modal)
    {
        //        se o usuário não for um transportador
        if (!\Yii::$app->user->identity->transportadora) {
            return [
                'Oc\'s vinculados' => Os::findAll(['id_usuario' => \Yii::$app->user->identity->id])
            ];
        }
        $os = Os::findOne($numero_os);
        $modal = Viagens::findOne($id_modal);

        if (!$modal) {
            return [
                'message' => 'Viagem não encontrada'
            ];
        }
        if ($modal->status === 'concluída') {
            $this->setStatus(422);
            return [
                'message' => 'Não é possível alterar uma viagem já concluída'
            ];
        }

        $modal->load(\Yii::$app->request->getBodyParams(), '');
        $modal->ultimaAtualizacao = date('Y-m-d H:i:s');
        $modal->save();

        $viagens = $os->viagens;
        $viagensResult = [];
        foreach ($viagens as $viagen) {
            $viagensResult[] = [
                'portoOrigem' => [
                    'id' => $viagen->portoOrigem0->id,
                    'nome' => $viagen->portoOrigem0->name
                ],
                'portoDestino' => [
                    'id' => $viagen->portoDestino0->id,
                    'nome' => $viagen->portoDestino0->name
                ],
                'status' => $viagen->status,
                'dataEmissao' => str_replace(' ', 'T', $viagen->dataEmissao),
                'ultimaAtualizacao' => str_replace(' ', 'T', $viagen->ultimaAtualizacao)
            ];
        }
        return [
            'os' => $os->codigo,
            'cliente' => $os->usuario->cnpj,
            'porto' => $viagens[0]->id,
            'dataEmissao' => $os->data_criacao,
            'multimodal' => $viagensResult
        ];
    }
}