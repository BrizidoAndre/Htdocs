<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $minutes_lenght
 * @property string $uploaded_at
 *
 * @property Comment[] $comments
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'minutes_lenght', 'uploaded_at'], 'required'],
            [['description'], 'string'],
            [['minutes_lenght'], 'integer'],
            [['uploaded_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return ['title', 'description'];
    }
    public function extraFields()
    {
        return ['comments'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'minutes_lenght' => 'Minutes Lenght',
            'uploaded_at' => 'Uploaded At',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['id_video' => 'id']);
    }
}
