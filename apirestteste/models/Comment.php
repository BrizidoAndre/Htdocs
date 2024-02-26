<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $textcomment
 * @property int $id_video
 *
 * @property Video $video
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['textcomment', 'id_video'], 'required'],
            [['textcomment'], 'string'],
            [['id_video'], 'integer'],
            [['id_video'], 'exist', 'skipOnError' => true, 'targetClass' => Video::class, 'targetAttribute' => ['id_video' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'textcomment' => 'Textcomment',
            'id_video' => 'Id Video',
        ];
    }

    /**
     * Gets query for [[Video]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::class, ['id' => 'id_video']);
    }
}
