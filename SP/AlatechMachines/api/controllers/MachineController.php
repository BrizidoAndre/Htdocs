<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\Storagedevice;
use Faker\Provider\Image;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class MachineController extends Controller
{

    public function actionPost()
    {
        $model = \Yii::$app->request->getBodyParams();

//        Declarando o array que conterá as mensagens de resposta
        $errors = [];

//        criando os modelos que serão usado para validação do cadastro de máquina
        $machine = new Machine();

        $machine->name = $model['name'];
        $machine->description = $model['description'];
        $machine->motherboardId = $model['motherboardId'];
        $machine->processorId = $model['processorId'];
        $machine->ramMemoryId = $model['ramMemoryId'];
        $machine->ramMemoryAmount = $model['ramMemoryAmount'];
        $machine->graphicCardId = $model['graphicCardId'];
        $machine->graphicCardAmount = $model['graphicCardAmount'];
        $machine->powerSupplyId = $model['powerSupplyId'];
        $machine->imageUrl = $model['imageUrl'];

        $machine->imageUrl = $this->generateImageId($machine->imageUrl);

        $storageDevices = $model['storageDevices'];

//         criando variáveis para validação dos dispositivos de armazenamento
        $sataAmount = 0;
        $m2Amount = 0;


        foreach ($storageDevices as $storageDevice) {

//            buscando dispositivo com base no id fornecido
            $typeStorage = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);

//            validação para caso não encontrar o dispositivo de armazenamento
            if (!$typeStorage) {
                $errors['Dispositivo de armazenamento'] = 'Não foi encontrado um dispositivo de armazenamento com o ID fornecido';
            }

            if ($typeStorage->storageDeviceInterface === 'sata') {
                $sataAmount += $storageDevice['amount'];
            }
            if ($typeStorage->storageDeviceInterface === 'm2') {
                $m2Amount += $storageDevice['amount'];
            }
        }


        if ($machine->motherboard->socketTypeId !== $machine->processor->socketTypeId) {
            $errors['Tipo de soquete'] = 'Tipo de soquete da placa-mãe e processador distintos';
        }
        if ($machine->motherboard->maxTdp < $machine->processor->tdp) {
            $errors['TDP'] = 'O tdp do processador supera o suportado pela placa-mãe';
        }
        if ($machine->motherboard->ramMemoryTypeId !== $machine->ramMemory->ramMemoryTypeId) {
            $errors['Tipo de memória RAM'] = 'O tipo de memória ram é diferente do suportado pela placa-mãe';
        }
        if ($machine->motherboard->ramMemorySlots < $machine->ramMemoryAmount) {
            $errors['Slots de memória RAM'] = 'A quantidade da memória RAM supear o suportado pela placa-mãe';
        }
        if ($machine->motherboard->pciSlots < $machine->graphicCardAmount || $machine->graphicCardAmount < 1) {
            $errors['Quantidade de placas de vídeo'] = 'A quantidade de placas de vídeo não condiz o suportado pela placa-mãe';
        }
        if ($machine->motherboard->sataSlots < $sataAmount) {
            $errors['Armazenamento Sata'] = 'A quantidade de armazenamento SATA é maior que o suportado pela placa-mãe';
        }
        if ($machine->motherboard->m2Slots < $m2Amount) {
            $errors['Armazenamento m2'] = 'A quantidade de armazenamento m2 é maior que o suportado pela placa-mãe';
        }
        if ($sataAmount + $m2Amount < 1) {
            $errors['Armazenamento'] = 'A máquina não contém um dispositivo de armazenamento';
        }
        if ($machine->graphicCardAmount > 1 && !$machine->graphicCard->supportMultiGpu) {
            $errors['Multi GPU'] = 'A placa de vídeo não suporta CROSSFIRE';
        }
        if ($machine->powerSupply->potency < $machine->graphicCard->minimumPowerSupply * $machine->graphicCardAmount) {
            $errors['Potência'] = 'A potência do carregador é inferior ao exigido pelas placas de vídeo';
        }

        if (count($errors) === 0) {

            $machine->save();

//            cadastrando a máquina para cadastrar os dispositivos de armazenamento junto com a máquina
            foreach ($storageDevices as $storageDevice) {
                $MhasS = new Machinehasstoragedevice();

                $MhasS->machineId = $machine->id;
                $MhasS->amount = $storageDevice['amount'];
                $MhasS->storageDeviceId = $storageDevice['storageDeviceId'];

                $MhasS->save();
            }

            return $machine;
        }

        \Yii::$app->response->statusCode = 422;
        return $errors;


    }

    public function actionPut($id)
    {

        $model = \Yii::$app->request->getBodyParams();


//        Declarando o array que conterá as mensagens de resposta
        $errors = [];

//        criando os modelos que serão usado para validação do cadastro de máquina
        $machine = Machine::findOne(['id' => $id]);

        $machine->name = $model['name'];
        $machine->description = $model['description'];
        $machine->motherboardId = $model['motherboardId'];
        $machine->processorId = $model['processorId'];
        $machine->ramMemoryId = $model['ramMemoryId'];
        $machine->ramMemoryAmount = $model['ramMemoryAmount'];
        $machine->graphicCardId = $model['graphicCardId'];
        $machine->graphicCardAmount = $model['graphicCardAmount'];
        $machine->powerSupplyId = $model['powerSupplyId'];

        if ($model['imageUrl']) {
            $machine->imageUrl = $model['imageUrl'];
            $machine->imageUrl = $this->generateImageId($machine->imageUrl);
        }


        $storageDevices = $model['storageDevices'];

//         criando variáveis para validação dos dispositivos de armazenamento
        $sataAmount = 0;
        $m2Amount = 0;


        foreach ($storageDevices as $storageDevice) {

//            buscando dispositivo com base no id fornecido
            $typeStorage = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);

//            validação para caso não encontrar o dispositivo de armazenamento
            if (!$typeStorage) {
                $errors['Dispositivo de armazenamento'] = 'Não foi encontrado um dispositivo de armazenamento com o ID fornecido';
            }

            if ($typeStorage->storageDeviceInterface === 'sata') {
                $sataAmount += $storageDevice['amount'];
            }
            if ($typeStorage->storageDeviceInterface === 'm2') {
                $m2Amount += $storageDevice['amount'];
            }
        }


        if ($machine->motherboard->socketTypeId !== $machine->processor->socketTypeId) {
            $errors['Tipo de soquete'] = 'Tipo de soquete da placa-mãe e processador distintos';
        }
        if ($machine->motherboard->maxTdp < $machine->processor->tdp) {
            $errors['TDP'] = 'O tdp do processador supera o suportado pela placa-mãe';
        }
        if ($machine->motherboard->ramMemoryTypeId !== $machine->ramMemory->ramMemoryTypeId) {
            $errors['Tipo de memória RAM'] = 'O tipo de memória ram é diferente do suportado pela placa-mãe';
        }
        if ($machine->motherboard->ramMemorySlots < $machine->ramMemoryAmount) {
            $errors['Slots de memória RAM'] = 'A quantidade da memória RAM supear o suportado pela placa-mãe';
        }
        if ($machine->motherboard->pciSlots < $machine->graphicCardAmount || $machine->graphicCardAmount < 1) {
            $errors['Quantidade de placas de vídeo'] = 'A quantidade de placas de vídeo não condiz o suportado pela placa-mãe';
        }
        if ($machine->motherboard->sataSlots < $sataAmount) {
            $errors['Armazenamento Sata'] = 'A quantidade de armazenamento SATA é maior que o suportado pela placa-mãe';
        }
        if ($machine->motherboard->m2Slots < $m2Amount) {
            $errors['Armazenamento m2'] = 'A quantidade de armazenamento m2 é maior que o suportado pela placa-mãe';
        }
        if ($sataAmount + $m2Amount < 1) {
            $errors['Armazenamento'] = 'A máquina não contém um dispositivo de armazenamento';
        }
        if ($machine->graphicCardAmount > 1 && !$machine->graphicCard->supportMultiGpu) {
            $errors['Multi GPU'] = 'A placa de vídeo não suporta CROSSFIRE';
        }
        if ($machine->powerSupply->potency < $machine->graphicCard->minimumPowerSupply * $machine->graphicCardAmount) {
            $errors['Potência'] = 'A potência do carregador é inferior ao exigido pelas placas de vídeo';
        }

        if (count($errors) === 0) {

            $machine->save();

//            cadastrando a máquina para cadastrar os dispositivos de armazenamento junto com a máquina
            foreach ($storageDevices as $storageDevice) {
                $MhasS = new Machinehasstoragedevice();

                $MhasS->machineId = $machine->id;
                $MhasS->amount = $storageDevice['amount'];
                $MhasS->storageDeviceId = $storageDevice['storageDeviceId'];

                $MhasS->save();
            }

            return $machine;
        }

        \Yii::$app->response->statusCode = 422;
        return $errors;


    }

//    public function actionVerify()
//    {
//        $model = \Yii::$app->request->getBodyParams();
//
//
////        Declarando o array que conterá as mensagens de resposta
//        $errors = [];
//
//        if (!\Yii::$app->request->hasProperty('powerSupplyId')){
//            $errors['Propriedades obrigatórias faltando'] = 'O id da placa mãe ou o id do Processador está faltando na requisição';
//        return $errors;
//    }
//
////        criando os modelos que serão usado para validação do cadastro de máquina
//        $machine = new Machine();
//
//        $machine->name = $model['name'];
//        $machine->description = $model['description'];
//        $machine->motherboardId = $model['motherboardId'];
//        $machine->processorId = $model['processorId'];
//        $machine->ramMemoryId = $model['ramMemoryId'];
//        $machine->ramMemoryAmount = $model['ramMemoryAmount'];
//        $machine->graphicCardId = $model['graphicCardId'];
//        $machine->graphicCardAmount = $model['graphicCardAmount'];
//        $machine->powerSupplyId = $model['powerSupplyId'];
//        $machine->imageUrl = $model['imageUrl'];
//
//        $machine->imageUrl = $this->generateImageId($machine->imageUrl);
//
//        $storageDevices = $model['storageDevices'];
//
////         criando variáveis para validação dos dispositivos de armazenamento
//        $sataAmount = 0;
//        $m2Amount = 0;
//
//
//        foreach ($storageDevices as $storageDevice) {
//
////            buscando dispositivo com base no id fornecido
//            $typeStorage = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);
//
////            validação para caso não encontrar o dispositivo de armazenamento
//            if (!$typeStorage) {
//                $errors['Dispositivo de armazenamento'] = 'Não foi encontrado um dispositivo de armazenamento com o ID fornecido';
//            }
//
//            if ($typeStorage->storageDeviceInterface === 'sata') {
//                $sataAmount += $storageDevice['amount'];
//            }
//            if ($typeStorage->storageDeviceInterface === 'm2') {
//                $m2Amount += $storageDevice['amount'];
//            }
//        }
//
//
//        if ($machine->motherboard->socketTypeId !== $machine->processor->socketTypeId) {
//            $errors['Tipo de soquete'] = 'Tipo de soquete da placa-mãe e processador distintos';
//        }
//        if ($machine->motherboard->maxTdp < $machine->processor->tdp) {
//            $errors['TDP'] = 'O tdp do processador supera o suportado pela placa-mãe';
//        }
//        if ($machine->motherboard->ramMemoryTypeId !== $machine->ramMemory->ramMemoryTypeId) {
//            $errors['Tipo de memória RAM'] = 'O tipo de memória ram é diferente do suportado pela placa-mãe';
//        }
//        if ($machine->motherboard->ramMemorySlots < $machine->ramMemoryAmount) {
//            $errors['Slots de memória RAM'] = 'A quantidade da memória RAM supear o suportado pela placa-mãe';
//        }
//        if ($machine->motherboard->pciSlots < $machine->graphicCardAmount || $machine->graphicCardAmount < 1) {
//            $errors['Quantidade de placas de vídeo'] = 'A quantidade de placas de vídeo não condiz o suportado pela placa-mãe';
//        }
//        if ($machine->motherboard->sataSlots < $sataAmount) {
//            $errors['Armazenamento Sata'] = 'A quantidade de armazenamento SATA é maior que o suportado pela placa-mãe';
//        }
//        if ($machine->motherboard->m2Slots < $m2Amount) {
//            $errors['Armazenamento m2'] = 'A quantidade de armazenamento m2 é maior que o suportado pela placa-mãe';
//        }
//        if ($sataAmount + $m2Amount < 1) {
//            $errors['Armazenamento'] = 'A máquina não contém um dispositivo de armazenamento';
//        }
//        if ($machine->graphicCardAmount > 1 && !$machine->graphicCard->supportMultiGpu) {
//            $errors['Multi GPU'] = 'A placa de vídeo não suporta CROSSFIRE';
//        }
//        if ($machine->powerSupply->potency < $machine->graphicCard->minimumPowerSupply * $machine->graphicCardAmount) {
//            $errors['Potência'] = 'A potência do carregador é inferior ao exigido pelas placas de vídeo';
//        }
//
//        if (count($errors) === 0) {
//
//            return [
//                'message' => 'Máquina válida'
//            ];
//        }
//
//        \Yii::$app->response->statusCode = 422;
//        return $errors;
//
//
//    }

    public function actionDelete($id)
    {
        $machine = Machine::findOne(['id' => $id]);
        if ($machine) {
            Machinehasstoragedevice::deleteAll(['machineId' => $id]);
            Machine::deleteAll(['id' => $id]);

            \Yii::$app->response->statusCode = 204;
            return;
        }
        throw new NotFoundHttpException('Modelo de máquina não encontrado');
    }

    //    método para receber o base 64 realizar o download e enviar um id
    public function generateImageId($base)
    {

        $imageId = random_int(0, 999999);

        $imageAll = $imageId . '.png';

        $folderPath = \Yii::getAlias('@webroot/images/');

        file_put_contents($folderPath . $imageAll, base64_decode($base));

        return (string)$imageId;
    }

}