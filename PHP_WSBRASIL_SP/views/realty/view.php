<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Realty $model */

$this->title = $model->realtyid;
$this->params['breadcrumbs'][] = ['label' => 'Realties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="realty-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'realtyid' => $model->realtyid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'realtyid' => $model->realtyid], [
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
            'realtyid',
            'address',
            'num_rooms',
            'offer_type:boolean',
            'rooms_qt',
            'toilet_qt',
            'parkingspace_qt',
            'value',
            'comment:ntext',
            'neighborhoodId',
            'categoryid',
        ],
    ]) ?>

</div>
