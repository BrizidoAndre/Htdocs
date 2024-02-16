<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Eggs $model */

$this->title = 'Create Eggs';
$this->params['breadcrumbs'][] = ['label' => 'Eggs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eggs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
