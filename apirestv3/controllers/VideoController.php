<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Video;
use yii\web\Controller;
use yii\web\View;

class VideoController extends ActiveController
{

    public $modelClass = 'app\models\Video';

}