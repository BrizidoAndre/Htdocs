<?php

namespace app\controllers;

use app\models\Accesstoken;
use app\models\Movie;
use app\models\Review;
use app\models\Reviewevaluation;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class ReviewsController extends Controller
{

    public function actionPost($movieId)
    {

        $movie = Movie::findOne(['id' => $movieId]);

        if (!$movie) {
            \Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Invalid movie id'
            ];
        }

        $user = \Yii::$app->user->identity;

        $oldReview = Review::find()->andWhere(['movieId' => $movieId])->andWhere(['userId' => $user->id])->one();

        if ($oldReview) {

            $oldReview->load(\Yii::$app->request->getBodyParams(), '');

            if (!\Yii::$app->request->getBodyParam('content')) {
                $oldReview->content = '';
            }

            if (!$oldReview->validate()) {
                \Yii::$app->response->statusCode = 422;
                return [
                    'message' => 'Invalid properties',
                    'errors' => $oldReview->errors
                ];
            }

            $oldReview->save();

            return [
                'message' => 'Review has been successfully updated'
            ];
        }


        $review = new Review();

        if ($review->load(\Yii::$app->request->getBodyParams(), '')) {

            $review->userId = $user->id;
            $review->movieId = $movieId;
            if (!$review->validate()) {
                \Yii::$app->response->statusCode = 422;
                return [
                    'message' => 'Invalid properties',
                    'errors' => $review->errors
                ];
            }

            if ($review->save()) {
                \Yii::$app->response->statusCode = 201;
                return [
                    'message' => 'Review has been successfully created'
                ];
            }


        }

        throw new BadRequestHttpException('No body');
    }


    public function actionMovie(
        $movieId,
        $page = 1,
        $pageSize = 10,
        $sortDir = 'desc',
        $sortBy = 'score'
    )
    {

        $sortDir = $sortDir === 'asc' ?  SORT_ASC : SORT_DESC;

        if (!Movie::findOne(['id' => $movieId])) {
            \Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Invalid movie id'
            ];
        }


        $query = Review::find();

        $query->addSelect(['review.*', 'COUNT( IF(reviewevaluation.positive = TRUE, 1, NULL)) - COUNT( IF( reviewevaluation.positive = FALSE, 1, NULL)) AS score']);

        $query->joinWith('reviewevaluations');
        $query->groupBy('review.id');
        $query->orderBy([
            $sortBy => $sortDir
        ]);
        $query->andWhere(['movieId' => $movieId]);


        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1,
            ]
        ]);
    }


    public function actionDelete($movieId)
    {
        $movie = Movie::findOne(['id' => $movieId]);

        if (!$movie) {
            \Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Invalid movie id'
            ];
        }

        $user = \Yii::$app->user->identity;
        $review = Review::find()->andWhere(['movieId' => $movieId])->andWhere(['userId' => $user->id])->one();

        if ($review) {

            Reviewevaluation::deleteAll(['reviewId' => $review->id]);
            $review->delete();
            \Yii::$app->response->statusCode = 204;
            return;
        }

        \Yii::$app->response->statusCode = 404;
        return [
            'message' => 'You haven\'t published a review to this movie'
        ];
    }


    public function actionEvaluation($reviewId)
    {
        $review = Review::findOne(['id' => $reviewId]);

        if (!$review) {
            \Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Invalid movie id'
            ];
        }


        $evaluation = new Reviewevaluation();

        $evaluation->userId = \Yii::$app->user->identity->id;
        $evaluation->reviewId = $reviewId;

        $evaluation->positive = \Yii::$app->request->getBodyParam('positive');

        if (!$evaluation->validate()) {
            \Yii::$app->response->statusCode = 422;
            return [
                'message' => 'Invalid properties',
                'errors' => $evaluation->errors
            ];
        }

        if ($review->userId === $evaluation->userId) {
            \Yii::$app->response->statusCode = 403;
            return [
                'message' => 'The user cant evaluate his own review',
            ];
        }
        $oldEvaluation = Reviewevaluation::find()->andWhere(['userId'=>$evaluation->userId])->andWhere(['reviewId' => $review->id])->one();

        if($oldEvaluation){
            $oldEvaluation->setAttributes($evaluation->attributes);

            $oldEvaluation->save();
            return [
                'message' => 'Review evaluation has been successfully updated'
            ];
        }

        \Yii::$app->response->statusCode = 201;
        $evaluation->save();
        return [
            'message' => 'Review evaluation has been successfully created'
        ];
    }


    public function actionDeletevaluation($reviewId){
        $review = Review::findOne(['id' => $reviewId]);

        if(!$review){
            \Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Invalid review id'
            ];
        }

        $user  = \Yii::$app->user->identity;

        $evaluation = Reviewevaluation::find()->andWhere(['reviewId' => $reviewId])->andWhere(['userId' => $user->id])->one();

        if(!$evaluation){
            \Yii::$app->response->statusCode = 404;
            return [
                'message' => 'You haven\' published a evaluation to this review'
            ];
        }

        $evaluation->delete();
        \Yii::$app->response->statusCode = 204;
        return '';
    }



    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result); // TODO: Change the autogenerated stub
    }


}