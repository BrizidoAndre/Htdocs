<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "containers".
 *
 * @property string $codigo
 * @property string $id_os
 *
 * @property Products[] $products
 */
class Containers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'containers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'id_os'], 'required'],
            [['codigo'], 'string', 'max' => 255],
            [['id_os'], 'string', 'max' => 13],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'id_os' => 'Id Os',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['id_container' => 'codigo']);
    }
}
