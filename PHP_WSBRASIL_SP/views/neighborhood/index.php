<?php

use app\models\Neighborhood;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\NeighborhoodSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bairros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Neighborhood', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Bairro',
                'value' => 'name',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Neighborhood $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'neighborhoodId' => $model->neighborhoodId]);
                }
            ],
        ],
        'emptyText' => '<p class="display-6 text-center">Nenhum bairro cadastrado</p>'
    ]); ?>


</div>
