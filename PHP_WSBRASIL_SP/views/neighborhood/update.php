<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Neighborhood $model */

$this->title = 'Update Neighborhood: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Neighborhoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'neighborhoodId' => $model->neighborhoodId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="neighborhood-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
