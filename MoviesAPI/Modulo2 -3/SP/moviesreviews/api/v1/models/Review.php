<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $userId
 * @property int $movieId
 * @property string|null $content
 * @property int|null $stars
 * @property string $createdAt
 *
 * @property Movie $movie
 * @property Reviewevaluation[] $reviewevaluations
 * @property User $user
 */
class Review extends \yii\db\ActiveRecord
{
    public $score;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'movieId', 'stars'], 'required'],
            [['userId', 'movieId', 'stars'], 'integer'],
            [['stars'], 'integer', 'max' => 10, 'min' => 1],
            [['content'], 'string'],
            [['createdAt'], 'safe'],
            [['movieId'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::class, 'targetAttribute' => ['movieId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }


    public function fields()
    {
        return [
            'id',
            'username' => function () {
                return $this->user->username;
            },
            'content',
            'stars',
            'score',
            'createdAt',
            'myEvaluation' => function () {
                $user = Yii::$app->user->identity;
                $mySupport = Reviewevaluation::find()->andWhere(['userId' => $user->id])->andWhere(['reviewId' => $this->id])->one();
                if ($mySupport) {
                    return $mySupport->positive;
                }
                return null;
            }
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
            'movieId' => 'Movie ID',
            'content' => 'Content',
            'stars' => 'Stars',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Movie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movie::class, ['id' => 'movieId']);
    }

    /**
     * Gets query for [[Reviewevaluations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewevaluations()
    {
        return $this->hasMany(Reviewevaluation::class, ['reviewId' => 'id']);
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
