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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'imageUrl', 'motherboardId', 'processorId', 'ramMemoryId', 'ramMemoryAmount', 'graphicCardId', 'graphicCardAmount', 'powerSupplyId'], 'required'],
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

    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'imageUrl',
            'motherboardId',
            'processorId',
            'ramMemoryId',
            'ramMemoryAmount',
            'graphicCardId',
            'graphicCardAmount',
            'powerSupplyId'
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


    public function generateIdImage($base64){

        $image = base64_decode($base64);

//        generate random int for imageId
        $id = random_int(1,999999);

        if(str_starts_with($image, '/9j/')){

            $imagePath = Yii::getAlias("@webroot") . '/images/' . $id . '.jpg';

            file_put_contents($imagePath,$image);
        }
        else{
            $imagePath = Yii::getAlias("@webroot") . '/images/' . $id . '.png';

            file_put_contents($imagePath,$image);
        }

        $this->imageUrl = (string) $id;
    }



    public function verify($sataTotal, $m2Total ){
        $errors = [];

        if($this->processor && $this->motherboard->socketTypeId !== $this->processor->socketTypeId){
            $errors['Tipo do soquete'] = 'Tipo de soquete da placa-mãe é diferente do tipo de soquete do processador';
        }

        if($this->processor && $this->motherboard->maxTdp < $this->processor->tdp){
            $errors['TDP'] = 'TDP do processador é maior do que o TDP máximo suportado pela placa-mãe';
        }

        if($this->ramMemory && $this->motherboard->ramMemoryTypeId !== $this->ramMemory->ramMemoryTypeId){
            $errors['Tipo da memória RAM'] = 'Tipo de memória RAM da placa-mãe é diferente do tipo da memória RAM';
        }

        if($this->motherboard->ramMemorySlots < $this->ramMemoryAmount){
            $errors['Quantidade de memória RAM'] = 'Quantidade de memórias RAM for maior que a quantidade de slots presentes na placa-mãe';
        }

        if($this->graphicCardAmount && (    $this->motherboard->pciSlots < $this->graphicCardAmount || $this->graphicCardAmount < 1 )){
            $errors['Quantidade de placas de vídeo'] = 'A quantidade de placas de vídeo é incompatível com a placa-mãe';
        }

        if($this->motherboard->sataSlots < $sataTotal){
            $errors['Armazenamento tipo SATA'] = 'A quantidade de disposistivos tipo SATA é maior que o suportado pela placa-mãe';
        }
        if($this->motherboard->sataSlots < $m2Total){
            $errors['Armazenamento tipo M2'] = 'A quantidade de disposistivos tipo m2 é maior que o suportado pela placa-mãe';
        }
        if($m2Total + $sataTotal < 1){
            $errors['Quantidade de armazenamento'] = 'A máquina não tem armazenamento';
        }

        if($this->graphicCard && $this->graphicCardAmount > 1 && $this->graphicCard->supportMultiGpu){
            $errors['Suporte Crossfire'] = 'A placa de vídeo indicada não suporta crossfire';
        }

        if($this->graphicCard && $this->powerSupply->potency < $this->graphicCard->minimumPowerSupply * $this->graphicCardAmount){
            $errors['Fonte insuficiente'] = 'A fonte de energia não provem o exigido mínimo pelas placas de vídeo';
        }

        return $errors;
    }


}
