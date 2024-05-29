<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property string|null $nomefantasia
 * @property string|null $endereço
 * @property string|null $historia
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['historia'], 'string'],
            [['nomefantasia', 'endereço'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomefantasia' => 'Nomefantasia',
            'endereço' => 'Endereço',
            'historia' => 'Historia',
        ];
    }
}
