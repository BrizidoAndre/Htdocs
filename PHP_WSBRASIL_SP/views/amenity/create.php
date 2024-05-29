<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Amenity $model */

$this->title = 'Create Amenity';
$this->params['breadcrumbs'][] = ['label' => 'Amenities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="amenity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
