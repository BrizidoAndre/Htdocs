<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviewevaluation".
 *
 * @property int $id
 * @property int $userId
 * @property int $reviewId
 * @property bool $positive
 *
 * @property Review $review
 * @property User $user
 */
class Reviewevaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviewevaluation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'reviewId', 'positive'], 'required'],
            [['userId', 'reviewId'], 'integer'],
            [['positive'], 'boolean'],
            [['reviewId'], 'exist', 'skipOnError' => true, 'targetClass' => Review::class, 'targetAttribute' => ['reviewId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'reviewId' => 'Review ID',
            'positive' => 'Positive',
        ];
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::class, ['id' => 'reviewId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

}
