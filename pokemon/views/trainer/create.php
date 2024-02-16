<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Trainer $model */

$this->title = 'Create Trainer';
$this->params['breadcrumbs'][] = ['label' => 'Trainers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trainer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
