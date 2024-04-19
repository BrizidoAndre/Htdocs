<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\Viewmodels\MachineForm;
use yii\web\NotFoundHttpException;

class MachineController extends JsonController
{

    public function actionPost(){

        $newMachineForm = new MachineForm();
        $newMachine = new Machine();

        if($newMachineForm->load(\Yii::$app->request->getBodyParams(), '')){

            if(!$newMachineForm->validate()){
                return $newMachineForm->errors;
            }

            $newMachine->setAttributes($newMachineForm->attributes);


            $newMachine->generateIdImage($newMachineForm->imageBase64);

            $newMachine->name = 'Varios armazenamentos';
            $newMachine->description = 'uma boa descrição';

            $storageResponse = $newMachineForm->prepareStorage();

            if(!is_array($storageResponse)){
                \Yii::$app->response->statusCode = 422;
                return [
                    'Armazenamento da máquina' => $storageResponse
                ];
            }

            $errors = $newMachine->verify($storageResponse['sata'], $storageResponse['m2']);

            if(count($errors) > 0){
                \Yii::$app->response->statusCode= 422;
                return $errors;
            }

            if(!$newMachine->save()){
                return $newMachine;
            }

            $this->saveStorages($storageResponse['storages'], $newMachine->id);

            \Yii::$app->response->statusCode = 201;
            return $newMachine;
        }
    }

    public function actionDelete($id){
        $deleteMachine = Machine::findOne(['id' => $id]);

        if(!$deleteMachine){
            throw new NotFoundHttpException('Modelo de máquina não encontrado');
        }

        Machinehasstoragedevice::deleteAll(['machineId' => $id]);
        $deleteMachine->delete();
        \Yii::$app->response->statusCode = 204;
    }

    public function actionVerify(){
        $verifyMachine = new MachineForm();
        $machine = new Machine();

        $verifyMachine->setScenario(MachineForm::SCENARIO_VERIFY);

        if($verifyMachine->load(\Yii::$app->request->getBodyParams(),'')){

            if(!$verifyMachine->validate()){
                return $verifyMachine->errors;
            }


            $machine->setAttributes($verifyMachine->attributes);

            $machine->name = 'Varios armazenamentos';
            $machine->description = 'uma boa descrição';

            $storageResponse = $verifyMachine->prepareStorage();


            if(!is_array($storageResponse)){
                \Yii::$app->response->statusCode = 422;
                return [
                    'Armazenamento da máquina' => $storageResponse
                ];
            }

            $errors = $machine->verify($storageResponse['sata'], $storageResponse['m2']);

            if(count($errors) > 0){
                \Yii::$app->response->statusCode= 422;
                return $errors;
            }

            return [
                'message' => 'máquina válida'
            ];
        }
    }


    public function actionPut($id){
        $newMachineForm = new MachineForm();
        $newMachine = new Machine();


        $newMachineForm->imageBase64 = 'nothing';

        $searchedMachine = Machine::findOne(['id' => $id]);

        if(!$searchedMachine){
            return [
                'message' => 'máquina não encontrada'
            ];
        }

        Machinehasstoragedevice::deleteAll(['machineId' => $id]);
        $searchedMachine->delete();

        if($newMachineForm->load(\Yii::$app->request->getBodyParams(), '')){

            if(!$newMachineForm->validate()){
                return $newMachineForm->errors;
            }

            $newMachine->setAttributes($newMachineForm->attributes);


            if($newMachineForm->imageBase64 !== 'nothing'){
                $newMachine->generateIdImage($newMachineForm->imageBase64);
            }


            $newMachine->name = 'Varios armazenamentos';
            $newMachine->description = 'uma boa descrição';

            $storageResponse = $newMachineForm->prepareStorage();

            if(!is_array($storageResponse)){
                \Yii::$app->response->statusCode = 422;
                return [
                    'Armazenamento da máquina' => $storageResponse
                ];
            }

            $errors = $newMachine->verify($storageResponse['sata'], $storageResponse['m2']);

            if(count($errors) > 0){
                \Yii::$app->response->statusCode= 422;
                return $errors;
            }

            $newMachine->id = $id;

            if(!$newMachine->save()){
                return $newMachine;
            }

            $this->saveStorages($storageResponse['storages'], $newMachine->id);

            \Yii::$app->response->statusCode = 201;
            return $newMachine;
        }
    }


    function saveStorages($storageDevices, $idMachine){

        foreach ( $storageDevices as $storageDevice) {

            $MhasS = new Machinehasstoragedevice();

            $MhasS->storageDeviceId = $storageDevice['id'];
            $MhasS->amount = $storageDevice['amount'];
            $MhasS->machineId = $idMachine;

            $MhasS->save();
        }
    }

}