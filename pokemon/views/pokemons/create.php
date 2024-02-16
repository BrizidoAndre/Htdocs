<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pokemons $model */

$this->title = 'Create Pokemons';
$this->params['breadcrumbs'][] = ['label' => 'Pokemons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pokemons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
