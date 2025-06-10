<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "porto".
 *
 * @property string|null $name
 * @property int $id
 * @property string $status
 * @property string $pais
 * @property string $latitude
 * @property string $longitude
 *
 * @property Os[] $os
 * @property Viagens[] $viagens
 * @property Viagens[] $viagens0
 */
class Porto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'porto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'pais', 'latitude', 'longitude'], 'required'],
            [['name', 'pais'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            [['status'], 'in', 'range' => ['operação','em andamento','reparação']],
            [['latitude', 'longitude'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'id' => 'ID',
            'status' => 'Status',
            'pais' => 'Pais',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[Os]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasMany(Os::class, ['id_porto' => 'id']);
    }

    /**
     * Gets query for [[Viagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViagens()
    {
        return $this->hasMany(Viagens::class, ['portoDestino' => 'id']);
    }

    /**
     * Gets query for [[Viagens0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViagens0()
    {
        return $this->hasMany(Viagens::class, ['portoOrigem' => 'id']);
    }
}
