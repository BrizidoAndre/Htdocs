<?php

namespace app\models;


use yii\base\Model;

class MachineRequest extends Model
{
    const SCENARIO_VERIFY = 'verify';

    public $storageDevices = [];
    public $imageBase64 = '';
    public $motherboardId = '';
    public $processorId = '';
    public $ramMemoryId = '';
    public $ramMemoryAmount = '';
    public $graphicCardId = '';
    public $graphicCardAmount = '';
    public $powerSupplyId = '';

    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario[self::SCENARIO_VERIFY] = ['motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId', 'storageDevices'];

        return $scenario;
    }

    public function rules()
    {
        return [
            [['imageBase64', 'motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId', 'storageDevices'], 'required'],
            [['motherboardId', 'powerSupplyId'], 'required', 'on' => self::SCENARIO_VERIFY],
        ];
    }

    public function validateImage()
    {
        if (str_starts_with($this->imageBase64, '/9j/')) {
            return true;
        }
        if (str_starts_with($this->imageBase64, 'iVBORw0KGg')) {
            return true;
        }
        return false;
    }

    public function saveImage()
    {
        $image = base64_decode($this->imageBase64);
        $idForImage = random_int(0, 999999);


        if (str_starts_with($this->imageBase64, '/9j/')) {
            file_put_contents(\Yii::getAlias('@webroot') . '/images/' . $idForImage . '.jpg', $image);
        } else {
            file_put_contents(\Yii::getAlias('@webroot') . '/images/' . $idForImage . '.png', $image);
        }

        return $idForImage;
    }

    public function getStorages()
    {
        $sataAmount = 0;
        $m2Amount = 0;

        $machineHasStorages = [];

        foreach ($this->storageDevices as $storageDevice) {

            $storageType = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);

            if ($storageType === null) {
                return ['error' => true];
            }

            if ($storageType->storageDeviceInterface === 'sata') {
                $sataAmount += $storageDevice['amount'];
            } else if ($storageType->storageDeviceInterface === 'm2') {
                $m2Amount += $storageDevice['amount'];
            }

            $MHasS = [
                'storageDeviceId' => $storageType->id,
                'amount' => $storageDevice['amount']
            ];

            $machineHasStorages[] = $MHasS;

        }

        return [
            'error' => false,
            'sata' => $sataAmount,
            'm2' => $m2Amount,
            'mhass' => $machineHasStorages
        ];
    }

    public function saveStoragesPut($id)
    {

        $sataAmount = 0;
        $m2Amount = 0;

        Machinehasstoragedevice::deleteAll(['machineId' => $id]);

        $machineHasStorages = [];

        foreach ($this->storageDevices as $storageDevice) {

            $storageType = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);

            if ($storageType === null) {
                return ['error' => true];
            }

            if ($storageType->storageDeviceInterface === 'sata') {
                $sataAmount += $storageDevice['amount'];
            } else if ($storageType->storageDeviceInterface === 'm2') {
                $m2Amount += $storageDevice['amount'];
            }

            $MHasS = [
                'storageDeviceId' => $storageType->id,
                'amount' => $storageDevice['amount']
            ];

            $machineHasStorages[] = $MHasS;

        }

        return [
            'error' => false,
            'sata' => $sataAmount,
            'm2' => $m2Amount,
            'mhass' => $machineHasStorages
        ];
    }

}