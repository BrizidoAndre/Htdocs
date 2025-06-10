<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grades".
 *
 * @property int $id
 * @property int $grade
 * @property string $subject
 * @property int $id_user
 *
 * @property Users $user
 */
class Grades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade', 'subject', 'id_user'], 'required'],
            [['grade', 'id_user'], 'integer'],
            [['subject'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grade' => 'Grade',
            'subject' => 'Subject',
            'id_user' => 'Id User',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'id_user']);
    }
}
