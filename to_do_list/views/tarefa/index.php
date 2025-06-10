<?php

use app\models\Tarefa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TarefaSearch $searchModel */
/** @var Tarefa [] $toDo */
/** @var Tarefa [] $doing */
/** @var Tarefa [] $done */

$this->title = 'Tarefas';
?>
<div class="tarefa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col">
            <h3 class="text-center">A fazer</h3>
            <?php foreach ($toDo as $task): ?>
                <?= Html::beginForm(['tarefa/status'], 'PUT') ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $task->Setor ?>
                        </h5>
                        <p class="card-text">Descrição: <?= $task->Descricao ?></p>
                        <p class="card-text">Data: <?= Yii::$app->formatter->asDate($task->DataCadastro) ?></p>

                        <ul class="list-group list-group-flush">
                            <div class="d-none">
                                <?= Html::hiddenInput('IdTarefa', $task->IdTarefa) ?>
                            </div>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 1, [
                                    'label' => 'A fazer',
                                    'value' => 1
                                ]) ?>
                            </li>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 2, [
                                    'label' => 'Fazendo',
                                    'value' => 2
                                ]) ?>
                            </li>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 3, [
                                    'label' => 'Feito',
                                    'value' => 3
                                ]) ?>
                            </li>
                        </ul>
                        <?= Html::submitButton('Alterar status', ['class' => 'btn btn-outline-primary mt-2']) ?>
                        <?= Html::a('Editar', ['tarefa/update','IdTarefa' => $task->IdTarefa],['class' => 'btn btn-outline-warning']) ?>
                        <?= Html::a('Deletar', ['tarefa/delete','IdTarefa' => $task->IdTarefa],['class' => 'btn btn-outline-danger']) ?>
                    </div>
                </div>
                <?= Html::endForm() ?>
            <?php endforeach ?>
        </div>
        <div class="col">
            <h3 class="text-center">Fazendo</h3>
            <?php foreach ($doing as $task): ?>
                <?= Html::beginForm(['tarefa/status'], 'PUT') ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $task->Setor ?>
                        </h5>
                        <p class="card-text">Descrição: <?= $task->Descricao ?></p>
                        <p class="card-text">Data: <?= Yii::$app->formatter->asDate($task->DataCadastro) ?></p>

                        <ul class="list-group list-group-flush">
                            <div class="d-none">
                                <?= Html::hiddenInput('IdTarefa', $task->IdTarefa) ?>
                            </div>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 1, [
                                    'label' => 'A fazer',
                                    'value' => 1
                                ]) ?>
                            </li>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 2, [
                                    'label' => 'Fazendo',
                                    'value' => 2
                                ]) ?>
                            </li>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 3, [
                                    'label' => 'Feito',
                                    'value' => 3
                                ]) ?>
                            </li>
                        </ul>
                        <?= Html::submitButton('Alterar status', ['class' => 'btn btn-outline-primary mt-2']) ?>
                        <?= Html::a('Editar', ['tarefa/update','IdTarefa' => $task->IdTarefa],['class' => 'btn btn-outline-warning']) ?>
                        <?= Html::a('Deletar', ['tarefa/delete','IdTarefa' => $task->IdTarefa],['class' => 'btn btn-outline-danger']) ?>
                    </div>
                </div>
                <?= Html::endForm() ?>
            <?php endforeach ?>
        </div>
        <div class="col">
            <h3 class="text-center">Feito</h3>
            <?php foreach ($done as $task): ?>
                <?= Html::beginForm(['tarefa/status'], 'PUT') ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $task->Setor ?>
                        </h5>
                        <p class="card-text">Descrição: <?= $task->Descricao ?></p>
                        <p class="card-text">Data: <?= Yii::$app->formatter->asDate($task->DataCadastro) ?></p>

                        <ul class="list-group list-group-flush">
                            <div class="d-none">
                                <?= Html::hiddenInput('IdTarefa', $task->IdTarefa) ?>
                            </div>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 1, [
                                    'label' => 'A fazer',
                                    'value' => 1
                                ]) ?>
                            </li>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 2, [
                                    'label' => 'Fazendo',
                                    'value' => 2
                                ]) ?>
                            </li>
                            <li class="list-group-item">
                                <?= Html::radio('status', $task->idStatus->IdStatus === 3, [
                                    'label' => 'Feito',
                                    'value' => 3
                                ]) ?>
                            </li>
                        </ul>
                        <?= Html::submitButton('Alterar status', ['class' => 'btn btn-outline-primary mt-2']) ?>
                        <?= Html::a('Editar', ['tarefa/update','IdTarefa' => $task->IdTarefa],['class' => 'btn btn-outline-warning']) ?>
                        <?= Html::a('Deletar', ['tarefa/delete','IdTarefa' => $task->IdTarefa],['class' => 'btn btn-outline-danger']) ?>
                    </div>
                </div>
                <?= Html::endForm() ?>
            <?php endforeach ?>
        </div>
    </div>
</div>
