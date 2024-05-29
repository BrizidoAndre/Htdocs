<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Amenity $model */

$this->title = 'Update Amenity: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Amenities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'amenityId' => $model->amenityId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="amenity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
