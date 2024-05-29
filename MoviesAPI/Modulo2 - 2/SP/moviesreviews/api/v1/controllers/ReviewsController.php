<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Movie;
use app\models\Review;
use app\models\Reviewevaluation;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ReviewsController extends JsonController
{

    public function actionPost($idMovie)
    {
        if (!Movie::findOne(['id' => $idMovie])) {
            throw new BadRequestHttpException('Invalid movie id');
        }

        $user = \Yii::$app->user->identity;

        $newReview = new Review();

        if ($newReview->load(\Yii::$app->request->getBodyParams(), '')) {

            $newReview->movieId = $idMovie;
            $newReview->userId = $user->id;

            if (!$newReview->validate()) {
                return $newReview->errors;
            }


            $searchReview = Review::find()->andWhere(['movieId' => $newReview->movieId])
                ->andWhere(['userId' => $newReview->userId])->one();

            if ($searchReview) {
                $searchReview->setAttributes($newReview->attributes);
                if ($searchReview->save()) {
                    return [
                        'message' => 'Review has been successfully updated'
                    ];
                }
            }


            if ($newReview->save()) {
                \Yii::$app->response->statusCode = 201;
                return [
                    'message' => 'Review has been successfully created'
                ];
            }

        }

    }


    public function actionGet(
        $movieId,
//        $page = 1,
        $pageSize = 10,
        $sortDir = 'desc',
        $sortBy = 'score'
    )
    {
        if (!Movie::findOne(['id' => $movieId])) {
            throw new BadRequestHttpException('Invalid movie Id');
        }

        if ($sortDir !== 'asc' && $sortDir !== 'desc') {
            throw new BadRequestHttpException('Valor inválido para SORT DIR');
        }
        if ($sortBy !== 'score' && $sortBy !== 'stars' && $sortBy !== 'createdAt') {
            throw new BadRequestHttpException('Valor inválido para $sortBy');
        }


        $reviews = Review::find()
            ->select(['review.*', 'COUNT( IF(reviewevaluation.positive = 1, 1, NULL)) - COUNT( IF( reviewevaluation.positive = 0, 1 ,NULL)) AS score'])
            ->joinWith('reviewevaluations')
            ->groupBy('review.id')
            ->orderBy($sortBy . ' ' . $sortDir)
            ->where(['movieId' => $movieId]);


        return new ActiveDataProvider([
            'query' => $reviews,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
    }


    public function actionDelete($movieId)
    {

        if (!Movie::findOne(['id' => $movieId])) {
            throw new NotFoundHttpException('Invalid movie id');
        }

        $user = \Yii::$app->user->identity;

        $reviewSearched = Review::findOne(['userId' => $user->id]);
        if (!$reviewSearched) {
            throw new NotFoundHttpException('You haven\'t published a review to this movie');
        }

        Reviewevaluation::deleteAll(['reviewId' => $reviewSearched->id]);
        $reviewSearched->delete();

        \Yii::$app->response->statusCode = 204;
        return;
    }


    public function actionPostevaluation($reviewId)
    {
        $review = Review::findOne(['id' => $reviewId]);

        if (!$review) {
            throw new BadRequestHttpException('Invalid review id');
        }

        $user = \Yii::$app->user->identity;

        $newEvaluation = new Reviewevaluation();
        $newEvaluation->userId = $user->id;
        $newEvaluation->reviewId = $reviewId;
        $newEvaluation->positive = \Yii::$app->request->getBodyParam('positive');


        if(!$newEvaluation->validate()){
            \Yii::$app->response->statusCode = 422;
            return [
                'message' => 'Invalid properties',
                'errors' => $newEvaluation->errors
            ];
        }



        if($review->userId === $user->id){
            throw new ForbiddenHttpException('The user cant evaluate his own review');
        }

        $userEvaluation = Reviewevaluation::find()->andWhere(['userId' => $user->id])->andWhere(['reviewId' => $reviewId])->one();

        if($userEvaluation){
            $userEvaluation->positive = $newEvaluation->positive;

            $userEvaluation->save();

            return [
                'message' => 'Review evaluation has been successfully updated'
            ];
        }

        $newEvaluation->save();

        \Yii::$app->response->statusCode = 201;
        return [
            'messsage' => 'Review evaluation has been successfully created'
        ];
    }


    public function actionDeleteevaluation($reviewId){
        $review = Review::findOne(['id' => $reviewId]);

        if(!$review){
            throw new BadRequestHttpException('Invalid review id');
        }

        $user = \Yii::$app->user->identity;

        $evaluation = Reviewevaluation::find()->andWhere(['reviewId' => $reviewId])->andWhere(['userId' => $user->id])->one();

        if(!$evaluation){
            throw new NotFoundHttpException('You haven\'t published a evaluation to this review');
        }

        $evaluation->delete();
        \Yii::$app->response->setStatusCode(204);
        return;
    }

}