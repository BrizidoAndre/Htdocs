<?php

namespace app\controllers;

use app\models\Machine;
use app\models\Machinehasstoragedevice;
use app\models\Storagedevice;
use yii\base\Exception;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

class MachineController extends Controller
{

    public function actionPost()
    {

        try {


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

        } catch (\ErrorException $exception){
            throw new UnprocessableEntityHttpException('Não foram fornecidos parâmetros suficientes para a criação da máquina');
        }
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

//        validação caso a imagem não esteja presente
        if (isset($model['imageUrl'])) {
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

    public function actionVerify()
    {

        try {


            $model = \Yii::$app->request->getBodyParams();


//        Declarando o array que conterá as mensagens de resposta
            $errors = [];

//        verificação simples se as propriedades obrigatórias existem
            if (!isset($model['powerSupplyId']) || !isset($model['motherboardId'])) {
                $errors['Propriedades faltando'] = 'Não é possível verificar uma máquina sem o id da máquina ou o id do Processador';

                return $errors;
            }


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

                return [
                    'message' => 'Máquina válida'
                ];
            }

            \Yii::$app->response->statusCode = 422;
            return $errors;

        } catch (\ErrorException $exception){
            throw new UnprocessableEntityHttpException('A requisição não contém todos os parâmetros necessários');
        }
    }

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

        if(str_starts_with($base,"iVBORw0KGg")){
            $imageId = random_int(0, 999999);

            $imageAll = $imageId . '.png';

            $folderPath = \Yii::getAlias('@webroot/images/');

            file_put_contents($folderPath . $imageAll, base64_decode($base));

            return (string)$imageId;
        } else if(str_starts_with($base, '/9j/')){
            $imageId = random_int(0, 999999);

            $imageAll = $imageId . '.jpg';

            $folderPath = \Yii::getAlias('@webroot/images/');

            file_put_contents($folderPath . $imageAll, base64_decode($base));

            return (string)$imageId;
        }
        else{
            return 'Imagem não foi retornada corretamente';
        }


    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => [
                        '*',
                    ],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'POST',
                        'PUT',
                        'PATCH',
                        'DELETE',
                        'HEAD',
                        'OPTIONS',
                    ],
                    'Access-Control-Request-Headers' => [
                        '*',
                    ],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Allow-Origin' => [
                        '*',
                    ],
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
    }

}