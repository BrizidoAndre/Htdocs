<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Rammemory;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\rest\Controller;

class MachineController extends Controller
{
    public function actionIndex($pageSize = 20){

        $query = Machine::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
        ]);


        return $provider->getModels();
    }

    public function actionSearch($name,$pageSize=20){
        $query = Machine::find()->where(['=', 'name', $name]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
        ]);

        return $provider;
    }

    public function actionMachines(){
        $model = new Machine();
        $errors = [];

        if($model->load(\Yii::$app->getRequest()->getBodyParams(),'')){


            if($model->motherboard->socketType->name !== $model->processor->socketType->name){
                $errors['Processador-Soquete'] =  'Tipo de soquete da placa mãe diferente do soquete do processador';
            }

            if($model->motherboard->maxTdp < $model->processor->tdp){
                $errors['Processador-TDP'] = 'TDP do processador superior do que o suportado pela placa mãe';
            }

            if($model->motherboard->ramMemoryType->name !== $model->ramMemory->ramMemoryType->name){
                $errors['Memória RAM-Tipo'] = 'O tipo da memória RAM é diferente do suportado pela placa mãe';
            }

            if($model->motherboard->ramMemorySlots < $model->ramMemoryAmount){
                $errors['Memória RAM-Slots'] = 'O número de memórias RAM supera o número de slots apresentados pela placa-mãe';
            }
            if($model->ramMemoryAmount< 1) {
                $errors['Memória RAM-Slots'] = 'Não há nenhuma memória RAM para a placa mãe';
            }
            if($model->graphicCardAmount > 0 && !$model->graphicCard->supportMultiGpu){
                $errors['Placa de vídeo-SLI'] = 'O modelo da placa de vídeo não suporta SLI';
            }


            if($model->motherboard->pciSlots < $model->graphicCardAmount){
                echo $model->motherboard->pciSlots;
                echo '<br>';
                echo $model->graphicCardAmount;
                $errors['Placa de vídeo-Slots'] = 'O número de placas de vídeo supera o numero de slots da placa mãe';

            }
            if($model->powerSupply->potency < $model->graphicCard->minimumPowerSupply * $model->graphicCardAmount){
                $errors['Alimentador de energia-Potência'] = 'A capacidade do carregador é inferiro do exigido mínimo pela/pelas placa/placas-de-vídeo';

            }

            if (count($errors) > 0){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }

            if($model->save()){
            \Yii::$app->response->statusCode = 201;
            return $model;
            }

            return ['Erro inesperado'];


        }
        \Yii::$app->response->statusCode = 422;
        return ['Pedido' => 'O pedido não foi realizado corretamente.'];

    }

    public function actionPutMachines($id){
        $machine = Machine::find()->where(['=', 'id', $id]);
        $errors = [];

        if ($machine === null){
            return[
                'error' => 'Máquina não encontrada!'
            ];
        }

        $model = new Machine();

        if($model->load(\Yii::$app->getRequest()->getBodyParams(),'')){


            if($model->motherboard->socketType->name !== $model->processor->socketType->name){
                $errors['Processador-Soquete'] =  'Tipo de soquete da placa mãe diferente do soquete do processador';
            }

            if($model->motherboard->maxTdp < $model->processor->tdp){
                $errors['Processador-TDP'] = 'TDP do processador superior do que o suportado pela placa mãe';
            }

            if($model->motherboard->ramMemoryType->name !== $model->ramMemory->ramMemoryType->name){
                $errors['Memória RAM-Tipo'] = 'O tipo da memória RAM é diferente do suportado pela placa mãe';
            }

            if($model->motherboard->ramMemorySlots < $model->ramMemoryAmount){
                $errors['Memória RAM-Slots'] = 'O número de memórias RAM supera o número de slots apresentados pela placa-mãe';
            }
            if($model->ramMemoryAmount< 1) {
                $errors['Memória RAM-Slots'] = 'Não há nenhuma memória RAM para a placa mãe';
            }
            if($model->graphicCardAmount > 0 && !$model->graphicCard->supportMultiGpu){
                $errors['Placa de vídeo-SLI'] = 'O modelo da placa de vídeo não suporta SLI';
            }


            if($model->motherboard->pciSlots < $model->graphicCardAmount){
                $errors['Placa de vídeo-Slots'] = 'O número de placas de vídeo supera o numero de slots da placa mãe';

            }
            if($model->powerSupply->potency < $model->graphicCard->minimumPowerSupply * $model->graphicCardAmount){
                $errors['Alimentador de energia-Potência'] = 'A capacidade do carregador é inferiro do exigido mínimo pela/pelas placa/placas-de-vídeo';

            }


            if (count($errors) > 0){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }


            $machine = $model;

            if($machine->save()){
                \Yii::$app->response->statusCode = 201;
                return $machine;
            }


        }
        \Yii::$app->response->statusCode = 422;
        return ['Pedido' => 'O pedido não foi realizado corretamente.'];


    }

    public function actionDelete($id){
        $model = Machine::findOne($id);
        if($model ===null){
            \Yii::$app->response->statusCode= 404;
            return[
                'errors' => 'Modelo de máquina não encontrado'
            ];
        }
        \Yii::$app->response->statusCode = 204;
        $model->delete();

        return '';
    }

    public function actionVerify(){
        $model = new Machine();
        $errors = [];

        if($model->load(\Yii::$app->getRequest()->getBodyParams(), '')){
            if($model->motherboardId === null || $model->powerSupplyId=== null){
                return $errors['Propriedades Obrigatórias'] = 'A placa-mãe e o alimentador de energia devem ser inseridos';
            }



            if($model->motherboard->socketType->name !== $model->processor->socketType->name){
                $errors['Processador-Soquete'] =  'Tipo de soquete da placa mãe diferente do soquete do processador';
            }

            if($model->motherboard->maxTdp < $model->processor->tdp){
                $errors['Processador-TDP'] = 'TDP do processador superior do que o suportado pela placa mãe';
            }

            if($model->motherboard->ramMemoryType->name !== $model->ramMemory->ramMemoryType->name){
                $errors['Memória RAM-Tipo'] = 'O tipo da memória RAM é diferente do suportado pela placa mãe';
            }

            if($model->motherboard->ramMemorySlots < $model->ramMemoryAmount){
                $errors['Memória RAM-Slots'] = 'O número de memórias RAM supera o número de slots apresentados pela placa-mãe';
            }
            if($model->ramMemoryAmount< 1) {
                $errors['Memória RAM-Slots'] = 'Não há nenhuma memória RAM para a placa mãe';
            }
            if($model->graphicCardAmount > 0 && !$model->graphicCard->supportMultiGpu){
                $errors['Placa de vídeo-SLI'] = 'O modelo da placa de vídeo não suporta SLI';
            }


            if($model->motherboard->pciSlots < $model->graphicCardAmount){
                $errors['Placa de vídeo-Slots'] = 'O número de placas de vídeo supera o numero de slots da placa mãe';

            }
            if($model->powerSupply->potency < $model->graphicCard->minimumPowerSupply * $model->graphicCardAmount){
                $errors['Alimentador de energia-Potência'] = 'A capacidade do carregador é inferiro do exigido mínimo pela/pelas placa/placas-de-vídeo';

            }


            if (count($errors) > 0){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }

            return [
                'Message' => 'Máquina válida'
            ];


        }
        return [
            'message' => 'Requisição inválida'
        ];
    }

    public function behaviors()
    {
        return [];
    }

}