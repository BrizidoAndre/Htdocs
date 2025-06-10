<?php

/** @var yii\web\View $this */
/** @var [] $folders */
/** @var string $url
/** @var \app\models\FileModel [] $files
 */

$this->title = 'My Yii Application';
$beforeUrl = '';
if($url !== null){
    $beforeUrl = '/' . $url;
}
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">

        <h1 class="display-5 d-inline bg-dark text-light pb-2">Listing Page Layout</h1>

        <div class="row px-5 my-5">
            <div class="col shadow text-start">
                <nav>
                    <ul>
                        <?php foreach($folders as $folder): ?>
                        <li>
                            <?= \yii\helpers\Html::a($folder['name'], \yii\helpers\Url::base(true) . $folder['url']); ?>
                        </li>
                        <?php endforeach ?>
                        <?php foreach($files as $file): ?>
                        <li>
                            <?= \yii\helpers\Html::a($file->namePascal, \yii\helpers\Url::base(true) . $beforeUrl .'/'. $file->nameWithoutExtention); ?>
                            <?= '<p>' . $file->summary ?: '' . '</p>' ?>
                            
                        </li>
                        <?php endforeach ?>
                    </ul>
                </nav>
            </div>
            <div class="col shadow">
                <div class="mb-3 text-start">
                    <label for="search" class="form-label">Search</label>
                    <input type="email" class="form-control" id="search" name="search">
                    <button class="my-3 btn btn-outline-primary">Search</button>
                </div>
            </div>
        </div>
    </div>
</div>
