<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Filhote $model */

$this->title = 'Create Filhote';
$this->params['breadcrumbs'][] = ['label' => 'Filhotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filhote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
