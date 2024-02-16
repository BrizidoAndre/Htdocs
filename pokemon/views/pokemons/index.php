<?php

use app\models\Pokemons;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PokemonsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pokemon';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pokemons-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pokemons', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'name',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Digite o nome'
                ]
            ],
            'type',
            [
                "label" => 'Nome do treinador',
                'attribute' => "trainer.name"
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pokemons $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
