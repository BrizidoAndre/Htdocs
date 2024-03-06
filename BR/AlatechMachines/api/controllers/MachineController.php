<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\Storagedevice;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\rest\Controller;
use function PHPUnit\Framework\isNull;

class MachineController extends Controller
{
    public function actionCreate()
    {
        $model = \Yii::$app->getRequest()->getBodyParams('');

        $machine = new Machine();
        $MHasS = new Machinehasstoragedevice();

        $errors = [];

        $machine->name = $model['name'];
        $machine->description = $model['description'];
        $machine->imageUrl = $model['imageUrl'];
        $machine->motherboardId = $model['motherboardId'];
        $machine->processorId = $model['processorId'];
        $machine->ramMemoryId = $model['ramMemoryId'];
        $machine->ramMemoryAmount = $model['ramMemoryAmount'];
        $machine->graphicCardId = $model['graphicCardId'];
        $machine->graphicCardAmount = $model['graphicCardAmount'];
        $machine->powerSupplyId = $model['powerSupplyId'];

        $storageModel = $model['storageDevices'][0];

        $MHasS->amount = $storageModel['amount'];
        $MHasS->storageDeviceId = $storageModel['storageDeviceId'];

        $storage = Storagedevice::find()->where(['=','id',$storageModel['storageDeviceId']])->one();




        if ($machine->motherboard->socketType->name !== $machine->processor->socketType->name) {
            $errors['Socket Type'] = 'Soquete da placa mãe diferente do Processador';
        }
        if ($machine->motherboard->maxTdp < $machine->processor->tdp) {
            $errors['TDP'] = 'TDP do processador maior que a placa suporta';
        }
        if ($machine->motherboard->ramMemoryTypeId !== $machine->ramMemory->ramMemoryTypeId) {
            $errors['Memory Ram'] = 'Tipo da memória RAM é diferente do suportado pela placa-mãe';
        }
        if ($machine->motherboard->ramMemorySlots < $machine->ramMemoryAmount || $machine->ramMemoryAmount < 1) {
            $errors['Memory Ram Quantity'] = 'Quantidade de Memória ram incompatível';
        }
        if ($machine->motherboard->pciSlots < $machine->graphicCardAmount || $machine->graphicCardAmount < 1) {
            $errors['Graphic Card Quantity'] = 'Quantidade de placas de vídeo inconsistentes';
        }
        if (!$machine->graphicCard->supportMultiGpu && $machine->graphicCardAmount > 1) {
            $errors['Multi Gpu'] = 'A placa de vídeo não suporta SLI';
        }
        if ($machine->powerSupply->potency < $machine->graphicCard->minimumPowerSupply * $machine->graphicCardAmount) {
            $errors['Not enough power supply'] = 'The power suplly does not suplly the nedded energy';
        }


        if($storage->storageDeviceInterface === 'm2'){
            if($machine->motherboard->m2Slots < $MHasS->amount || $MHasS->amount < 1){
                $errors['M2 slots'] = 'Armazenamento tipo m2 incompatível com a placa-mãe';
            }
        }
        if($storage->storageDeviceInterface === 'sata'){
            if($machine->motherboard->sataSlots < $MHasS->amount || $MHasS->amount < 1){
                $errors['Sata slots'] = 'Armazenamento tipo sata incompatível com a placa-mãe';
            }
        }



        if (count($errors) > 0) {
            return $errors;
        }

        $machine->save();
        $MHasS->machineId = $machine->id;
        $MHasS->save();

        return $model;
    }
}