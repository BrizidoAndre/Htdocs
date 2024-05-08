<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "machine".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $imageUrl
 * @property int $motherboardId
 * @property int $processorId
 * @property int $ramMemoryId
 * @property int $ramMemoryAmount
 * @property int $graphicCardId
 * @property int $graphicCardAmount
 * @property int $powerSupplyId
 *
 * @property Graphiccard $graphicCard
 * @property Machinehasstoragedevice[] $machinehasstoragedevices
 * @property Motherboard $motherboard
 * @property Powersupply $powerSupply
 * @property Processor $processor
 * @property Rammemory $ramMemory
 * @property Storagedevice[] $storageDevices
 */
class Machine extends \yii\db\ActiveRecord
{

    public const SCENARIO_FORM = 'form';

    public $storageDevices;
    public $imageBase64;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_FORM] = ['name', 'description', 'imageUrl', 'motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId', 'storageDevices', 'imageBase64'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'imageUrl', 'motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId'], 'required', 'except' => 'form'],

            [['name', 'description', 'imageBase64', 'motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId', 'storageDevices'], 'required', 'on' => 'form'],
            [['motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId'], 'integer'],
            [['name'], 'string', 'max' => 96],
            [['description', 'imageUrl'], 'string', 'max' => 512],
            [['motherboardId'], 'exist', 'skipOnError' => true, 'targetClass' => Motherboard::class, 'targetAttribute' => ['motherboardId' => 'id']],
            [['processorId'], 'exist', 'skipOnError' => true, 'targetClass' => Processor::class, 'targetAttribute' => ['processorId' => 'id']],
            [['ramMemoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Rammemory::class, 'targetAttribute' => ['ramMemoryId' => 'id']],
            [['graphicCardId'], 'exist', 'skipOnError' => true, 'targetClass' => Graphiccard::class, 'targetAttribute' => ['graphicCardId' => 'id']],
            [['powerSupplyId'], 'exist', 'skipOnError' => true, 'targetClass' => Powersupply::class, 'targetAttribute' => ['powerSupplyId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'imageUrl' => 'Image Url',
            'motherboardId' => 'Motherboard ID',
            'processorId' => 'Processor ID',
            'ramMemoryId' => 'Ram Memory ID',
            'ramMemoryAmount' => 'Ram Memory Amount',
            'graphicCardId' => 'Graphic Card ID',
            'graphicCardAmount' => 'Graphic Card Amount',
            'powerSupplyId' => 'Power Supply ID',
        ];
    }

    /**
     * Gets query for [[GraphicCard]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGraphicCard()
    {
        return $this->hasOne(Graphiccard::class, ['id' => 'graphicCardId']);
    }

    /**
     * Gets query for [[Machinehasstoragedevices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachinehasstoragedevices()
    {
        return $this->hasMany(Machinehasstoragedevice::class, ['machineId' => 'id']);
    }

    /**
     * Gets query for [[Motherboard]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMotherboard()
    {
        return $this->hasOne(Motherboard::class, ['id' => 'motherboardId']);
    }

    /**
     * Gets query for [[PowerSupply]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPowerSupply()
    {
        return $this->hasOne(Powersupply::class, ['id' => 'powerSupplyId']);
    }

    /**
     * Gets query for [[Processor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProcessor()
    {
        return $this->hasOne(Processor::class, ['id' => 'processorId']);
    }

    /**
     * Gets query for [[RamMemory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRamMemory()
    {
        return $this->hasOne(Rammemory::class, ['id' => 'ramMemoryId']);
    }

    /**
     * Gets query for [[StorageDevices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorageDevices()
    {
        return $this->hasMany(Storagedevice::class, ['id' => 'storageDeviceId'])->viaTable('machinehasstoragedevice', ['machineId' => 'id']);
    }

//transformando a imagem
    public function transformImage()
    {
        $this->imageBase64 = explode(',', $this->imageBase64)[1];

        $random = random_int(0, 9999999);

        if (str_starts_with('/9j/', $this->imageBase64)) {
            $image = base64_decode($this->imageBase64);

            $jpgPath = \Yii::getAlias('@webroot') . '/images/' . $random . '.jpg';

            file_put_contents($jpgPath, $image);

            return $random;
        }

        $image = base64_decode($this->imageBase64);

        $jpgPath = \Yii::getAlias('@webroot') . '/images/' . $random . '.png';

        file_put_contents($jpgPath, $image);

        return $random;
    }

    public function analiseMachine()
    {
        $errors = [];

        if ($this->processor && $this->motherboard->socketTypeId !== $this->processor->socketTypeId) {
            $errors['Tipo de soquete'] = 'Soquete da placa mãe diferente do processador';
        }
        if ($this->processor && $this->motherboard->maxTdp < $this->processor->tdp) {
            $errors['TDP'] = 'TDP máximo do processador supera o suportado pela placa mãe';
        }
        if ($this->ramMemory && $this->motherboard->ramMemoryType->id !== $this->ramMemory->ramMemoryType->id) {
            $errors['Memória RAM'] = 'O tipo de memória RAM é diferente do suportado pela placa-mãe';
        }
        if ($this->ramMemoryAmount && ($this->motherboard->ramMemorySlots < $this->ramMemoryAmount || $this->ramMemoryAmount < 1)) {
            $errors['Slots RAM'] = 'Número incompatível de memórias RAM com a placa-mãe';
        }
        if ($this->graphicCard && ($this->motherboard->pciSlots < $this->graphicCardAmount || $this->graphicCardAmount < 1)) {
            $errors['Slots PCI'] = 'Número incompatível de placas de vídeo com a placa-mãe';
        }
        if ($this->graphicCardAmount && $this->graphicCardAmount > 1 && $this->graphicCard->supportMultiGpu) {
            $errors['Crossfire'] = 'A placa de vídeo não suporta crossfire';
        }
        if ($this->graphicCard && $this->powerSupply->potency < $this->graphicCard->minimumPowerSupply * $this->graphicCardAmount) {
            $errors['Potência'] = "A fonte de alimentação não satisfaz o exigido pela placa de vídeo";
        }

        return $errors;
    }

    public function analiseStorageDevices()
    {

        $m2Amount = 0;
        $sataAmount = 0;

        foreach ($this->storageDevices as $storageDevice) {
            $storages = [];
            $storage = Storagedevice::findOne(['id' => $storageDevice['storageDeviceId']]);
            if (!$storage) {
                return [
                    'Armazenamento inválido' => 'Um id fornecido foi inválido'
                ];
            }
            if ($storage->storageDeviceInterface === 'm2') {
                $m2Amount += $storageDevice['amount'];
            }
            if ($storage->storageDeviceInterface === 'sata') {
                $sataAmount += $storageDevice['amount'];
            }
        }

        return [
            'm2' => $m2Amount,
            'sata' => $sataAmount
        ];
    }

    public function analiseStorageAmount($storageAmount)
    {
        $errors = [''];
        if ($this->motherboard->m2Slots < $storageAmount['m2']) {
            $errors['M2 slots'] = 'Quantidade de slots de m2 incompatível com a placa-mãe';
        }
        if ($this->motherboard->sataSlots < $storageAmount['sata']) {
            $errors['SATA slots'] = 'Quantidade de slots de sata incompatível com a placa-mãe';
        }

        return $errors;
    }
}
