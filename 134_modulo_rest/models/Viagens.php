<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "viagens".
 *
 * @property int $id
 * @property string $id_os
 * @property int $portoOrigem
 * @property int $portoDestino
 * @property string $status
 * @property string $dataEmissao
 * @property string $ultimaAtualizacao
 *
 * @property Os $os
 * @property Porto $portoDestino0
 * @property Porto $portoOrigem0
 */
class Viagens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_os', 'portoOrigem', 'portoDestino', 'status', 'dataEmissao'], 'required'],
            [['portoOrigem', 'portoDestino'], 'integer'],
            [['dataEmissao'],'date','format' => 'php:Y-m-d H:i:s'],
            [['ultimaAtualizacao'],'date','format' => 'php:Y-m-d H:i:s'],
            [['id_os'], 'string', 'max' => 13],
            [['status'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['pendente','em andamento','concluída']],
            [['id_os'], 'exist', 'skipOnError' => true, 'targetClass' => Os::class, 'targetAttribute' => ['id_os' => 'codigo']],
            [['portoDestino'], 'exist', 'skipOnError' => true, 'targetClass' => Porto::class, 'targetAttribute' => ['portoDestino' => 'id']],
            [['portoOrigem'], 'exist', 'skipOnError' => true, 'targetClass' => Porto::class, 'targetAttribute' => ['portoOrigem' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_os' => 'Id Os',
            'portoOrigem' => 'Porto Origem',
            'portoDestino' => 'Porto Destino',
            'status' => 'Status',
            'dataEmissao' => 'Data Emissao',
            'ultimaAtualizacao' => 'Ultima Atualizacao',
        ];
    }

    /**
     * Gets query for [[Os]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasOne(Os::class, ['codigo' => 'id_os']);
    }

    /**
     * Gets query for [[PortoDestino0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortoDestino0()
    {
        return $this->hasOne(Porto::class, ['id' => 'portoDestino']);
    }

    /**
     * Gets query for [[PortoOrigem0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortoOrigem0()
    {
        return $this->hasOne(Porto::class, ['id' => 'portoOrigem']);
    }
}
