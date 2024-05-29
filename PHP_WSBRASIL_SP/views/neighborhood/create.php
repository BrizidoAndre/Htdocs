<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Neighborhood $model */

$this->title = 'Create Neighborhood';
$this->params['breadcrumbs'][] = ['label' => 'Neighborhoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
