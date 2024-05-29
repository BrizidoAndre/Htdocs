<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Neighborhood $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Neighborhoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="neighborhood-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'neighborhoodId' => $model->neighborhoodId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'neighborhoodId' => $model->neighborhoodId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'neighborhoodId',
            'name',
            'cityid',
        ],
    ]) ?>

</div>
