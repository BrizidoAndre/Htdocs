<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\Machine;
use app\models\Machinehasstoragedevice;
use yii\web\NotFoundHttpException;

class MachineController extends JsonController
{

    public function actionPost()
    {
        $machine = new Machine(['scenario' => Machine::SCENARIO_FORM]);

//        setando os valores para a validação não reclamar

        $machine->name = 'nome';
        $machine->description = 'descrição';
        $machine->imageUrl = 's';

        if ($machine->load(\Yii::$app->request->getBodyParams(), '')) {

            if (!$machine->validate()) {
                return $machine->errors;
            }

            $errors = $machine->validateMachine();

            if (count($errors) > 0) {
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }


            $machine->generateImage();

            if ($machine->save()) {

                foreach ($machine->storageDevices as $storageDevice) {
                    $MhasS = new Machinehasstoragedevice();

                    $MhasS->machineId = $machine->id;
                    $MhasS->storageDeviceId = $storageDevice['storageDeviceId'];
                    $MhasS->amount = $storageDevice['amount'];

                    $MhasS->save();
                }

                return $machine;
            }
        }
    }

    public function actionVerify()
    {
        $machine = new Machine(['scenario' => Machine::SCENARIO_VERIFY]);

//        setando os valores para a validação não reclamar

        $machine->name = 'nome';
        $machine->description = 'descrição';
        $machine->imageUrl = 's';

        if ($machine->load(\Yii::$app->request->getBodyParams(), '')) {

            if (!$machine->validate()) {
                return $machine->errors;
            }

            $errors = $machine->validateMachine();

            if (count($errors) > 0) {
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }


            return [
                'message' => 'Máquina válida'
            ];
        }
    }


    public function actionDelete($id)
    {
        $machine = Machine::findOne(['id' => $id]);

        if (!$machine) {
            throw new NotFoundHttpException('Modelo de máquina não encontrado');
        }


        Machinehasstoragedevice::deleteAll(['machineId' => $id]);
        $machine->delete();

        \Yii::$app->response->statusCode = 204;
    }

    public function actionPut($id)
    {

        $machine = Machine::findOne(['id' => $id]);

        if (!$machine) {
            throw new NotFoundHttpException('Máquina não encontrada');
        }

        $machine->setScenario(Machine::SCENARIO_FORM);


        $machine->imageBase64 = 'nada';


        if ($machine->load(\Yii::$app->request->getBodyParams(), '')) {

            if (!$machine->validate()) {
                return $machine->errors;
            }


            $errors = $machine->validateMachine();

            if (count($errors) > 0) {
                \Yii::$app->response->statusCode = 422;
                return $errors;
            }

            if ($machine->imageBase64 !== 'nada') {
                $machine->generateImage();
            }

            if ($machine->save()) {

                Machinehasstoragedevice::deleteAll(['machineId' => $id]);
                foreach ($machine->storageDevices as $storageDevice) {
                    $MhasS = new Machinehasstoragedevice();

                    $MhasS->machineId = $machine->id;
                    $MhasS->storageDeviceId = $storageDevice['storageDeviceId'];
                    $MhasS->amount = $storageDevice['amount'];

                    $MhasS->save();
                }

                return $machine;
            }
        }
    }

}