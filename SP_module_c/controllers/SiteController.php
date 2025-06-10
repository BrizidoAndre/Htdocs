<?php

namespace app\controllers;

use app\models\FileModel;
use Faker\Core\File;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($url = '')
    {
        if (is_file('./content-pages' . '/' . $url . '.txt')) {
            $file = new FileModel('./content-pages' . '/' . $url . '.txt');
            return $this->render('page', [
                'file' => $file
            ]);
        }
        if (is_file('./content-pages' . '/' . $url . '.html')) {
            $file = new FileModel('./content-pages' . '/' . $url . '.html');
            return $this->render('page', [
                'file' => $file
            ]);
        }
        $files = [];
        $fileNames = FileHelper::findFiles('./content-pages/' . $url, [
            'recursive' => false,
        ]);
        $folders = FileHelper::findDirectories('./content-pages/' . $url, [
            'recursive' => false,
            'filter' => function ($model) {
                return !str_contains($model, 'images');
            }
        ]);

        sort($fileNames);
        $fileNames = array_reverse($fileNames);

        $folders = $this->prepareDirectories($folders, $url);

        foreach ($fileNames as $file) {
            $files[] = new FileModel($file);
        }
        $files = array_filter($files, function ($file) {
            $position = strrpos($file->fileName, '\\');
            $date = substr($file->fileName, $position + 1, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            return is_numeric($year) && is_numeric($month) && is_numeric($day) && !((bool)$file->draft);
        });

        return $this->render('index', [
            'files' => $files,
            'folders' => $folders,
            'url' => $url
        ]);
    }

    public function actionTag($tags)
    {
        $files = FileHelper::findFiles('./content-pages', [
            'except' => [
                '*.jpg',
                '*.png',
                '*.jpeg'
            ]
        ]);
        $teste = 0;

        sort($files);
        $files = array_reverse($files);

        $realFiles = [];
        foreach ($files as $file) {
            $realFiles[] = new FileModel($file);
        }
        $realFiles = array_filter($realFiles, function ($file){
            $position = strrpos($file->fileName, '\\');
            $date = substr($file->fileName, $position + 1, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);

            return is_numeric($year) && is_numeric($month) && is_numeric($day) && !((bool)$file->draft);
        });

        return $this->render('tag', [
            'files' => $realFiles,
            'url' => ''
        ]);
    }

    function prepareDirectories($folders, $url)
    {
        sort($folders);
        $manipulatedFolder = [];
        foreach ($folders as $folder) {
            $names = explode("\\", $folder);
            $nameCount = count($names);
            $firstOccurence = strpos($folder, '\\');

            $manipulatedFolder[] = [
                'name' => $names[$nameCount - 1],
                'url' => '/' . $url . substr($folder, $firstOccurence)
            ];
        }
        return $manipulatedFolder;
    }

    function debug($content)
    {
        echo '<pre>', var_dump($content), '</pre>';
    }
}
