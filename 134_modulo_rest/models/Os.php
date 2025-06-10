<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "os".
 *
 * @property string $codigo
 * @property int $id_usuario
 * @property int $id_porto
 * @property string $data_criacao
 * @property string $status
 *
 * @property Porto $porto
 * @property Users $usuario
 * @property Viagens[] $viagens
 */
class Os extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'os';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'id_usuario', 'id_porto', 'status'], 'required'],
            [['id_usuario', 'id_porto'], 'integer'],
            [['codigo'], 'string', 'max' => 13],
            [['status'], 'string', 'max' => 255],
            [['data_criacao'], 'date', 'format' => 'php:Y-m-d'],
            [['codigo'], 'unique'],
            [['id_porto'], 'exist', 'skipOnError' => true, 'targetClass' => Porto::class, 'targetAttribute' => ['id_porto' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'id_usuario' => 'Id Usuario',
            'id_porto' => 'Id Porto',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Porto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPorto()
    {
        return $this->hasOne(Porto::class, ['id' => 'id_porto']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Users::class, ['id' => 'id_usuario']);
    }

    /**
     * Gets query for [[Viagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViagens()
    {
        return $this->hasMany(Viagens::class, ['id_os' => 'codigo']);
    }
}
