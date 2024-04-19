<?php

namespace app\models\Viewmodels;

use app\models\Storagedevice;
use yii\base\Model;

class MachineForm extends Model
{
    public const SCENARIO_VERIFY = 'verify';

    public $motherboardId;

    public $powerSupplyId;
    public $processorId;
    public $ramMemoryId;
    public $ramMemoryAmount;
    public $storageDevices = [];

    public $graphicCardId;
    public $graphicCardAmount;
    public $imageBase64;


    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_VERIFY] = ['motherboardId', 'powerSupplyId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'storageDevices', 'graphicCardId', 'graphicCardAmount', 'imageBase64',];

        return $scenarios;
    }

    public function rules()
    {
        return [
            [['motherboardId',
                'powerSupplyId',
                'processorId',
                'ramMemoryId',
                'ramMemoryAmount',
                'storageDevices',
                'graphicCardId',
                'graphicCardAmount',
                'imageBase64',], 'required', 'except' => self::SCENARIO_VERIFY],
            [['motherboardId', 'powerSupplyId'], 'required', 'on' => self::SCENARIO_VERIFY]
        ];
    }




    public function prepareStorage(){

        $sataAmount = 0;
        $m2Amount = 0;

        $storages = [];

        foreach ($this->storageDevices as $storageDevice) {

            $storage = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);

            if(!$storage){
                return 'Armazenamento inválido';
            }


            if($storage->storageDeviceInterface === 'm2'){
                $m2Amount += $storageDevice['amount'];
            }
            if($storage->storageDeviceInterface === 'sata'){
                $sataAmount += $storageDevice['amount'];
            }

            $storages[] = [
                'id' => $storage->id,
                'amount' => $storageDevice['amount']
            ];
        }

        return [
            'sata' => $sataAmount,
            'm2' => $m2Amount,
            'storages' => $storages
        ];
    }
}