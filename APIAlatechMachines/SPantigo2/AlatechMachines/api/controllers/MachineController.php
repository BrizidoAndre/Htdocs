<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\Storagedevice;
use yii\rest\Controller;

class MachineController extends Controller
{

    public function actionPost()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $machine = new Machine();

        $MhasS = new Machinehasstoragedevice();

        $errors = [];

        $body = \Yii::$app->request->getBodyParams();

        $machine->name = $body['name'];
        $machine->description = $body['description'];
        $machine->imageUrl = $body['imageUrl'];
        $machine->motherboardId = $body['motherboardId'];
        $machine->processorId = $body['processorId'];
        $machine->ramMemoryId = $body['ramMemoryId'];
        $machine->ramMemoryAmount = $body['ramMemoryAmount'];
        $machine->graphicCardId = $body['graphicCardId'];
        $machine->graphicCardAmount = $body['graphicCardAmount'];
        $machine->powerSupplyId = $body['powerSupplyId'];


        $storage = Storagedevice::findOne(['id' => $body['storageDevices'][0]['storageDeviceId']]);

        if ($storage === null) {
            $errors['Tipo de armazenamento'] = 'Não existe o armazenamento indicado';
        }

        if ($machine->motherboard->socketTypeId !== $machine->processor->socketTypeId) {
            $errors['Tipo do soquete'] = 'O tipo de soquete da placa mãe e do processador são distindos';
        }
        if ($machine->motherboard->maxTdp < $machine->processor->tdp) {
            $errors['TDP'] = 'O TDP do  processador supera o suportado pela placa mãe';
        }
        if ($machine->motherboard->ramMemoryTypeId !== $machine->ramMemory->ramMemoryTypeId) {
            $errors['Tipo da memória RAM'] = 'O tipo da memória RAM e o suportado pela placa mãe são distintos';
        }
        if ($machine->motherboard->ramMemorySlots < $machine->ramMemoryAmount || $machine->ramMemoryAmount < 1) {
            $errors['Quantidade de memória RAM'] = 'A quantidade de Memória ram não se adequa a placa mãe';
        }
        if ($machine->graphicCardAmount < 1 || $machine->motherboard->pciSlots < $machine->graphicCardAmount) {
            $errors['Quantidade de placas de vídeo'] = 'A quantidade de placas de vídeo não se adequa a placa mãe';
        }
        if ($body['storageDevices'][0]['amount'] < 1) {
            $errors['Quantidade de armazenamento'] = 'A soma total de dispositivos de armazenamento deve ser maior que 1';
        }
        if ($machine->graphicCardAmount > 1 && !$machine->graphicCard->supportMultiGpu) {
            $errors['Placa de vídeo SLI'] = 'A placa de vídeo não suporta SLI';
        }
        if ($machine->powerSupply->potency < $machine->graphicCardAmount * $machine->graphicCard->minimumPowerSupply) {
            $errors['Fonte de alimentação'] = 'A fonte de alimentação não fornece a exigência mínima da/das placa de vídeo';
        }
        if ($machine->motherboard->m2Slots < $body['storageDevices'][0]['amount'] && $storage->storageDeviceInterface === 'm2') {
            $errors['Slots de armazenamento m2'] = 'A placa mãe não suporta a quantidade de armazenamento m2 indicada';
        }
        if ($machine->motherboard->sataSlots < $body['storageDevices'][0]['amount'] && $storage->storageDeviceInterface === 'sata') {
            $errors['Slots de armazenamento m2'] = 'A placa mãe não suporta a quantidade de armazenamento m2 indicada';
        }

        if (count($errors) > 0) {
            return $errors;
        }


        $machine->imageUrl = (string) $this->getIdImage($machine->imageUrl);

        $machine->save();

        $MhasS->machineId = $machine->id;
        $MhasS->amount = $body['storageDevices'][0]['amount'];
        $MhasS->storageDeviceId = $body['storageDevices'][0]['storageDeviceId'];


        $MhasS->save();

        return $machine;

    }

    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $machine = Machine::findOne(['id' => $id]);
        $MhasS = Machinehasstoragedevice::findOne(['machineId' => $id]);

        if ($machine === null || $MhasS === null) {
            \Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Modelo de máquina não encontrado'
            ];
        }

        $MhasS->delete();
        $machine->delete();

        \Yii::$app->response->statusCode = 204;
        return '';
    }

    public function actionVerify()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $machine = new Machine();

        $MhasS = new Machinehasstoragedevice();

        $errors = [];

        $body = \Yii::$app->request->getBodyParams();

        $machine->name = $body['name'];
        $machine->description = $body['description'];
        $machine->imageUrl = $body['imageUrl'];
        $machine->motherboardId = $body['motherboardId'];
        $machine->processorId = $body['processorId'];
        $machine->ramMemoryId = $body['ramMemoryId'];
        $machine->ramMemoryAmount = $body['ramMemoryAmount'];
        $machine->graphicCardId = $body['graphicCardId'];
        $machine->graphicCardAmount = $body['graphicCardAmount'];
        $machine->powerSupplyId = $body['powerSupplyId'];


        $storage = Storagedevice::findOne(['id' => $body['storageDevices'][0]['storageDeviceId']]);

        if ($storage === null) {
            $errors['Tipo de armazenamento'] = 'Não existe o armazenamento indicado';
        }

        if ($machine->motherboard->socketTypeId !== $machine->processor->socketTypeId) {
            $errors['Tipo do soquete'] = 'O tipo de soquete da placa mãe e do processador são distindos';
        }
        if ($machine->motherboard->maxTdp < $machine->processor->tdp) {
            $errors['TDP'] = 'O TDP do  processador supera o suportado pela placa mãe';
        }
        if ($machine->motherboard->ramMemoryTypeId !== $machine->ramMemory->ramMemoryTypeId) {
            $errors['Tipo da memória RAM'] = 'O tipo da memória RAM e o suportado pela placa mãe são distintos';
        }
        if ($machine->motherboard->ramMemorySlots < $machine->ramMemoryAmount || $machine->ramMemoryAmount < 1) {
            $errors['Quantidade de memória RAM'] = 'A quantidade de Memória ram não se adequa a placa mãe';
        }
        if ($machine->graphicCardAmount < 1 || $machine->motherboard->pciSlots < $machine->graphicCardAmount) {
            $errors['Quantidade de placas de vídeo'] = 'A quantidade de placas de vídeo não se adequa a placa mãe';
        }
        if ($body['storageDevices'][0]['amount'] < 1) {
            $errors['Quantidade de armazenamento'] = 'A soma total de dispositivos de armazenamento deve ser maior que 1';
        }
        if ($machine->graphicCardAmount > 1 && !$machine->graphicCard->supportMultiGpu) {
            $errors['Placa de vídeo SLI'] = 'A placa de vídeo não suporta SLI';
        }
        if ($machine->powerSupply->potency < $machine->graphicCardAmount * $machine->graphicCard->minimumPowerSupply) {
            $errors['Fonte de alimentação'] = 'A fonte de alimentação não fornece a exigência mínima da/das placa de vídeo';
        }
        if ($machine->motherboard->m2Slots < $body['storageDevices'][0]['amount'] && $storage->storageDeviceInterface === 'm2') {
            $errors['Slots de armazenamento m2'] = 'A placa mãe não suporta a quantidade de armazenamento m2 indicada';
        }
        if ($machine->motherboard->sataSlots < $body['storageDevices'][0]['amount'] && $storage->storageDeviceInterface === 'sata') {
            $errors['Slots de armazenamento m2'] = 'A placa mãe não suporta a quantidade de armazenamento m2 indicada';
        }

        if (count($errors) > 0) {
            \Yii::$app->response->statusCode = 422;
            return $errors;
        }
        \Yii::$app->response->statusCode = 200;
        return [
            'message' => 'Máquina válida'
        ];

    }


    public function getIdImage($image)
    {


// Set the current working directory
        $directory = getcwd() . "/images/";

// Initialize filecount variable
        $filecount = 0;
        $files2 = glob($directory . "*");

        if ($files2) {
            $filecount = count($files2);
        }

        $fileNewId = $filecount + 1;

        file_put_contents($directory . $fileNewId . '.png', base64_decode($image) . '.png');

        return $fileNewId;
    }

    public function actionGetid($id){
        return Machine::findOne(['id' => $id]);
    }
}