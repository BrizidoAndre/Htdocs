<?php

/** @var \app\models\FileModel $file
 */
?>
<div class="site-index" id="page-index">
    <div class="jumbotron box-page text-center bg-transparent mt-5 mb-5">
        <?php if ($file->image): ?>
            <img id="cover" class="image-cover"
                 src="<?= \yii\helpers\Url::base(true) . './content-pages/images/' . $file->image ?>"
                 alt="<?= $file->summary ?>">
        <?php endif ?>

        <h2 id="page-title" class="display-5 d-inline bg-dark text-light pb-2"><?= $file->title ?>
        </h2>

        <div class="row px-5 pt-5">
            <div class="col-7 shadow text-start box-content">
                <?php foreach ($file->content as $id => $line): ?>
                    <?= $line ?>
                <?php endforeach ?>
            </div>
            <div class="col-3 shadow text-start aside-fixed" style="top: 10%">
                <ul class="">
                    <?php if ($file->date): ?>
                        <li>
                            Date: <?= $file->date ?>
                        </li>
                    <?php endif ?>
                    <?php if ($file->summary): ?>
                        <li>
                            Summary: <?= $file->summary ?>
                        </li>
                    <?php endif ?>
                    <?php if ($file->tags): ?>
                        <li>
                            Tags: <?= implode(', ', $file->tags) ?>
                        </li>
                    <?php endif ?>
                    <?php if ($file->draft): ?>
                        <li>
                            Draft: <?= $file->draft ?>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    let image = document.getElementById('cover')
    image.addEventListener('click', () => {
        image.classList.toggle('image-full')
    })
    window.addEventListener('scroll', () => {
        image.classList.remove('image-full')
    })
</script>
