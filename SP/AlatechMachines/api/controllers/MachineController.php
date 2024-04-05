<?php

namespace app\controllers;

use app\Bases\JsonController;
use app\models\Machine;
use app\models\MachineRequest;
use app\models\User;
use yii\web\BadRequestHttpException;

class MachineController extends JsonController
{


//    todo ATENTAR-SE NESTE MÉTODO. ELE APLICA ÓTIMOS PASSOS
    public function actionIndex()
    {
        try {

            $machineRequest = new MachineRequest();
            $machine = new Machine();

            $machine->name = 'BORAAAAA';
            $machine->description = 'description';

            if($machineRequest->load(\Yii::$app->request->getBodyParams(), '')) {

                $machine->setAttributes($machineRequest->attributes,'');

                $machine->imageUrl = $machineRequest->imageBase64;
                $machine->storageDevices = $machineRequest->storageDevices;

                if($machineRequest->validate() && $machine->validate()){
                    $machine->save();
                    return $machine;
                }

                return $machine->errors;
            }

            throw new BadRequestHttpException('Requisição não foi feita corretamente');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}