<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Machine;
use app\models\Machinehasstoragedevice;
use yii\web\NotFoundHttpException;

class MachinesController extends JsonController
{

    public function actionPost(){
        $machineForm = new Machine();

        $machineForm->setScenario(Machine::SCENARIO_FORM);

        $machineForm->name = 'nome';
        $machineForm->description = 'descrição';

        if($machineForm->load(\Yii::$app->request->getBodyParams(),'')){

            if(!$machineForm->validate()){
                return $machineForm->errors;
            }


            $errors = $machineForm->analiseMachine();

            $storageErros = $machineForm->analiseStorageDevices();

            
            if(count($errors) > 0){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }
            if(count($storageErros) < 1){
                \Yii::$app->response->statusCode = 422;
                return $storageErros;
            }


            $errors = $machineForm->analiseStorageAmount($storageErros);

            if(isset($errors['M2 slots']) || isset($errors['SATA slots'])){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }

            $machineForm->imageUrl = (string) $machineForm->transformImage();
            
            if($machineForm->save()){
                foreach ($machineForm->storageDevices as $storageDevice) {
                    $newStorageDevice = new Machinehasstoragedevice();

                    $newStorageDevice->amount = $storageDevice['amount'];
                    $newStorageDevice->storageDeviceId = $storageDevice['storageDeviceId'];

                    $newStorageDevice->machineId = $machineForm->id;
                    $newStorageDevice->save();
                }

                \Yii::$app->response->statusCode = 201;
                return $machineForm;
            }

            return $machineForm;
        }
    }


    public function actionPut($id){
        $machineForm = Machine::findOne(['id' => $id]);

        if(!$machineForm){
            return [
                'message' => 'id não encontrado'
            ];
        }

        $machineForm->setScenario(Machine::SCENARIO_FORM);

        $machineForm->name = 'nome';
        $machineForm->description = 'descrição';

        if($machineForm->load(\Yii::$app->request->getBodyParams(),'')){

            if(!$machineForm->validate()){
                return $machineForm->errors;
            }


            $errors = $machineForm->analiseMachine();

            $storageErros = $machineForm->analiseStorageDevices();


            if(count($errors) > 0){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }
            if(count($storageErros) < 1){
                \Yii::$app->response->statusCode = 422;
                return $storageErros;
            }


            $errors = $machineForm->analiseStorageAmount($storageErros);

            if(isset($errors['M2 slots']) || isset($errors['SATA slots'])){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }



            if(!$machineForm->imageBase64){
            $machineForm->imageUrl = (string) $machineForm->transformImage();
            }

            if($machineForm->save()){
                foreach ($machineForm->storageDevices as $storageDevice) {
                    $newStorageDevice = new Machinehasstoragedevice();

                    $newStorageDevice->amount = $storageDevice['amount'];
                    $newStorageDevice->storageDeviceId = $storageDevice['storageDeviceId'];

                    $newStorageDevice->machineId = $machineForm->id;
                    $newStorageDevice->save();
                }

                \Yii::$app->response->statusCode = 201;
                return $machineForm;
            }

            return $machineForm;
        }
    }


    public function actionDelete($id){
        $machineFound = Machine::findOne(['id' => $id]);

        if(!$machineFound){
            throw new NotFoundHttpException('Modelo de máquina não encotrado');
        }

        Machinehasstoragedevice::deleteAll(['machineId' => $id]);

        $machineFound->delete();

        \Yii::$app->response->statusCode = 204;
    }

    public function actionVerify(){
        $machineForm = new Machine();

        $machineForm->setScenario(Machine::SCENARIO_FORM);

//        colocando coisas para a validação não der errado
        $machineForm->name = 'nome';
        $machineForm->description = 'descrição';
        $machineForm->imageBase64 = 'algo';

        if($machineForm->load(\Yii::$app->request->getBodyParams(),'')){

            if(!$machineForm->validate()){
                return $machineForm->errors;
            }


            $errors = $machineForm->analiseMachine();

            $storageErros = $machineForm->analiseStorageDevices();


            if(count($errors) > 0){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }
            if(count($storageErros) < 1){
                \Yii::$app->response->statusCode = 422;
                return $storageErros;
            }

            $errors = $machineForm->analiseStorageAmount($storageErros);

            if(isset($errors['M2 slots']) || isset($errors['SATA slots'])){
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }


            return [
                'message' => 'Máquina válida'
            ];
        }
    }



    public function actionHelp(){
        $machine = new Machine();

        $machine->setScenario(Machine::SCENARIO_FORM);

        $machine->load(\Yii::$app->request->getBodyParams(), '');

        return $machine->storageDevices;
    }
}