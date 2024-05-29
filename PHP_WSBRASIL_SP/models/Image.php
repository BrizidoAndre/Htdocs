<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $imageId
 * @property string|null $filepath
 * @property string|null $upload_date
 * @property bool|null $isThumbnail
 * @property int|null $realtyid
 *
 * @property Realty $realty
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageId'], 'required'],
            [['imageId', 'realtyid'], 'integer'],
            [['filepath'], 'string'],
            [['upload_date'], 'safe'],
            [['isThumbnail'], 'boolean'],
            [['imageId'], 'unique'],
            [['realtyid'], 'exist', 'skipOnError' => true, 'targetClass' => Realty::class, 'targetAttribute' => ['realtyid' => 'realtyid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'imageId' => 'Image ID',
            'filepath' => 'Filepath',
            'upload_date' => 'Upload Date',
            'isThumbnail' => 'Is Thumbnail',
            'realtyid' => 'Realtyid',
        ];
    }

    /**
     * Gets query for [[Realty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRealty()
    {
        return $this->hasOne(Realty::class, ['realtyid' => 'realtyid']);
    }
}
