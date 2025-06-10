<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tarefa $model */

$this->title = $model->IdTarefa;
$this->params['breadcrumbs'][] = ['label' => 'Tarefas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tarefa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdTarefa' => $model->IdTarefa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdTarefa' => $model->IdTarefa], [
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
            'IdTarefa',
            'Descricao',
            'Setor',
            'DataCadastro',
            'IdUsuario',
            'IdPrioridade',
            'IdStatus',
        ],
    ]) ?>

</div>
