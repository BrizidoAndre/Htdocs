<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $categoryid
 * @property string|null $name
 *
 * @property Realty[] $realties
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoryid'], 'required'],
            [['categoryid'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['categoryid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categoryid' => 'Categoryid',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Realties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRealties()
    {
        return $this->hasMany(Realty::class, ['categoryid' => 'categoryid']);
    }
}
