<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Movie;
use app\models\Review;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ReviewsController extends JsonController
{

    public function actionView($idMovie)
    {
        if (!Movie::findOne(['id' => $idMovie])) {
            throw new BadRequestHttpException('Invalid movie id');
        }

        $header = explode(' ', \Yii::$app->request->headers->get('authorization'))[1];
        $user = User::findIdentityByAccessToken($header);


        $newReview = new Review();

        if ($newReview->load(\Yii::$app->request->getBodyParams(), '')) {

            $newReview->movieId = $idMovie;
            $newReview->userId = $user->id;

            if (!$newReview->validate()) {
                return $newReview->errors;
            }


            $searchReview = Review::find()->andWhere(['movieId' => $newReview->movieId])->andWhere(['userId' => $newReview->userId])->one();

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
        $page = 1,
        $pageSize = 10,
        $sortDir = 'desc',
        $sortBy = 'score'
    )
    {
        if (!Movie::findOne(['id' => $movieId])) {
            throw new BadRequestHttpException('Invalid movie Id');
        }


        $reviews = Review::find()->where(['movieId' => $movieId]);

        return new ActiveDataProvider([
            'query' => $reviews,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);
    }

    
    public function actionDelete($movieId){

        if(!Movie::findOne(['id' => $movieId])){
            throw new NotFoundHttpException('Invalid movie id');
        }

        $header = explode(' ', \Yii::$app->request->headers->get('authorization'))[1];
        $user = User::findIdentityByAccessToken($header);



        $reviewSearched = Review::findOne(['userId' => $user->id]);


        if(!$reviewSearched){
            throw new NotFoundHttpException('You haven\'t published a review to this movie');
        }

        $reviewSearched->delete();

        \Yii::$app->response->statusCode = 204;
        return;

    }

}