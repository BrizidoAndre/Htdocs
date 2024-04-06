<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\MachineRequest;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class MachineController extends JsonController
{

//    todo ATENTAR-SE NESTE MÉTODO. ELE APLICA ÓTIMOS PASSOS
    public function actionIndex()
    {
        try {

            $machineRequest = new MachineRequest();
            $machine = new Machine();

            if ($machineRequest->load(\Yii::$app->request->getBodyParams(), '')) {

                $machine->setAttributes($machineRequest->attributes);


//                if($machineRequest->validate() && $machine->validate()){
//                    $machine->save();
//                    return $machine;
//                }

                return $machine->errors;
            }

//            esses bad request não setam o status code da resposta;
            throw new BadRequestHttpException('Requisição não foi feita corretamente');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionPost()
    {
        try {
            $errors = [];
            $machineRequest = new MachineRequest();
            $machine = new Machine();

//            setando valores para a validação
            $machine->name = 'Retestando método de cadastro';
            $machine->description = 'Descrição longa';
            $machine->imageUrl = 'ainda não decidida';

            if ($machineRequest->load(\Yii::$app->request->getBodyParams(), '')) {

                $machine->setAttributes($machineRequest->attributes);

                if (!$machine->validate()) {
                    return $machine->errors;
                }

                if (!$machineRequest->validateImage()) {
                    $errors['Imagem'] = 'Imagem inválida';
                }

                if ($machineRequest->validateImage()) {
                    $machine->imageUrl = (string)$machineRequest->saveImage();
                }


                $storageInfo = $machineRequest->getStorages();


                if ($storageInfo['error']) {
                    $errors['Dispositivo de armazenamento'] = 'Um dos id fornecidos para o armazenamneto é inválido';
                    return $errors;
                }

                $errors = array_merge($machine->verifyMachine($storageInfo['sata'], $storageInfo['m2']), $errors);

                if (count($errors) > 0) {

                    \Yii::$app->response->statusCode = 422;
                    return $errors;
                }

                $machine->save();

                foreach ($storageInfo['mhass'] as $mhass) {
                    $MhasSSave = new Machinehasstoragedevice();

                    $MhasSSave->machineId = $machine->id;
                    $MhasSSave->storageDeviceId = $mhass['storageDeviceId'];
                    $MhasSSave->amount = $mhass['amount'];

                    $MhasSSave->save();
                }

                return $machine;
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionVerify()
    {
        try {
            $errors = [];
            $machineRequest = new MachineRequest();
            $machine = new Machine();

            $machineRequest->setScenario(MachineRequest::SCENARIO_VERIFY);
            $machine->setScenario(Machine::SCENARIO_VERIFY);


            if ($machineRequest->load(\Yii::$app->request->getBodyParams(), '')) {

                $machine->setAttributes($machineRequest->attributes);

                if (!$machine->validate()) {
                    return $machine->errors;
                }

                $storageInfo = $machineRequest->getStorages();

                if ($storageInfo['error']) {
                    $errors['Dispositivo de armazenamento'] = 'Um dos id fornecidos para o armazenamento é inválido';
                    return $errors;
                }

                $errors = array_merge($machine->verifyMachine($storageInfo['sata'], $storageInfo['m2']), $errors);

                if (count($errors) > 0) {
                    \Yii::$app->response->statusCode = 422;
                    return $errors;
                }

                return [
                    'message' => 'Máquina válida'
                ];
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionDelete($id){
        try {

            $machine = Machine::findOne(['id' => $id]);

            if(Machinehasstoragedevice::deleteAll(['machineId' => $id]) > 0 && $machine->delete()){
                \Yii::$app->response->statusCode = 204;
                return '';
            }

            \Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Modelo de máquina não encontrado'
                ];

        } catch(\Exception $e){
            return $e->getMessage();
        } catch (\Throwable $e) {
            throw new NotFoundHttpException('Modelo de máquina não encontrado');
        }
    }


    public function actionPut($id){
        try {

            $errors =[];

            $machineRequest = new MachineRequest();
            $machine = Machine::findOne(['id' => $id]);

            if(!$machine){
                \Yii::$app->response->statusCode = 404;
                return [
                    'message' => 'Máquina não encontrada'
                ];
            }


            if ($machineRequest->load(\Yii::$app->request->getBodyParams(), '')) {

                $machine->setAttributes($machineRequest->attributes);


                if (!$machine->validate()) {
                    return $machine->errors;
                }

                if ($machineRequest->validateImage()) {
                    $machine->imageUrl = (string)$machineRequest->saveImage();
                }

                $storageInfo = $machineRequest->saveStoragesPut($machine->id);


                if ($storageInfo['error']) {
                    $errors['Dispositivo de armazenamento'] = 'Um dos id fornecidos para o armazenamento é inválido';
                    return $errors;
                }

                $errors = array_merge($machine->verifyMachine($storageInfo['sata'], $storageInfo['m2']), $errors);

                if (count($errors) > 0) {

                    \Yii::$app->response->statusCode = 422;
                    return $errors;
                }

                $machine->save();

                foreach ($storageInfo['mhass'] as $mhass) {
                    $MhasSSave = new Machinehasstoragedevice();

                    $MhasSSave->machineId = $machine->id;
                    $MhasSSave->storageDeviceId = $mhass['storageDeviceId'];
                    $MhasSSave->amount = $mhass['amount'];

                    $MhasSSave->save();
                }

                return $machine;
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



}