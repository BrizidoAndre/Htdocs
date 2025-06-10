<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property string $nota
 * @property string $id_container
 *
 * @property Containers $container
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota', 'id_container'], 'required'],
            [['nota'], 'string', 'max' => 44],
            [['id_container'], 'string', 'max' => 255],
            [['nota'], 'unique'],
            [['id_container'], 'exist', 'skipOnError' => true, 'targetClass' => Containers::class, 'targetAttribute' => ['id_container' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nota' => 'Nota',
            'id_container' => 'Id Container',
        ];
    }

    /**
     * Gets query for [[Container]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContainer()
    {
        return $this->hasOne(Containers::class, ['codigo' => 'id_container']);
    }
}
