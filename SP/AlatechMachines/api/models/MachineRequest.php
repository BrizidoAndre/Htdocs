<?php

namespace app\models;


use yii\base\Model;

class MachineRequest extends Model
{
    public $storageDevices = [];
    public $imageBase64 = '';
    public $motherboardId = '';
    public $processorId = '';
    public $ramMemoryId = '';
    public $ramMemoryAmount = '';
    public $graphicCardId = '';
    public $graphicCardAmount = '';
    public $powerSupplyId = '';

    public function rules()
    {
        return [
            [['imageBase64', 'motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId', 'storageDevices'], 'required'],
        ];
    }

}