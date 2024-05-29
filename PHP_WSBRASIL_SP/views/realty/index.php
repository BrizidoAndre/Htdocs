<?php

use app\models\Realty;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RealtySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Imóveis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Realty', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel ,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'realtyid',
            'address',
            'num_rooms',
            'offer_type:boolean',
            'rooms_qt',
//            'toilet_qt',
//            'parkingspace_qt',
//            'value',
//            'comment:ntext',
//            'neighborhoodId',
//            'categoryid',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Realty $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'realtyid' => $model->realtyid]);
                 }
            ],
        ],
        'emptyText' => "<p class='text-center display-6'>Desculpe por não temos o imóvel dos seus sonhos! <br> Por favor tente outras opções </p>"
    ]); ?>


</div>
