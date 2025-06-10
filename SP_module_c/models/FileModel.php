<?php

namespace app\models;

class FileModel
{
    public $content;
    public $date;
    public $namePascal;
    public $nameWithoutExtention;
    public $fileNameWithoutExtention;
    public $fileName;
    public $tags;
    public $title;
    public $summary;
    public $image;
    public $everything;
    public $draft;
    public function __construct($file)
    {
        $this->fileName = $file;
        $this->everything = file($this->fileName,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->getMetaData();
        $this->getNames();
        $this->getRealTitle();
        $this->adaptContent();
    }

    public function getNames()
    {
        $lastNameIndex = strrpos($this->fileName,'\\');
        $lastNameBarra = strrpos($this->fileName,'/');
        $completeName = substr($this->fileName,$lastNameIndex);

        $this->date = substr(substr($this->fileName, $lastNameBarra),1,10);

        $nameAssist = str_replace(['.txt','.html'],'',substr($completeName, 11));
        $this->nameWithoutExtention = str_replace(['.txt','.html','\\'],'',$completeName);
        $this->namePascal = ucwords(str_replace('-',' ',$nameAssist));
        $this->fileNameWithoutExtention = str_replace(['.txt','.html', './content-pages'],'', $this->fileName);
    }

    public function getMetaData(){
        $occurences =[];
        $hasMetaData =false;
        foreach ($this->everything as $id => $item) {
            if($item === '---'){
                $occurences[] = $id;
                $hasMetaData = true;
            }
        }
        $count = count($occurences);
        if($hasMetaData){
                $metas = [];
            for ($i = 1; $i < $occurences[$count -1]; $i++) {
                $metas[] = $this->everything[$i];
            }
            foreach ($metas as $meta) {
                if(str_contains($meta,'title: ')){
                    $this->title = str_replace("title: ",'',$meta);
                }if(str_contains($meta,'summary: ')){
                    $this->summary = str_replace("summary: ",'',$meta);
                }if(str_contains($meta,'cover: ')){
                    $this->image = str_replace("cover: ",'',$meta);
                }if(str_contains($meta,'tags: ')){
                    $this->tags = explode(',',str_replace("tags: ",'',$meta));
                }if(str_contains($meta,'draft: ')){
                    $this->draft = str_replace('draft: ','',$meta);
                }
            }
        }
        $this->content = array_slice($this->everything, $occurences[$count -1] +1);
    }

    public function adaptContent()
    {
        if(str_contains($this->fileName,'.txt')){
            foreach ($this->content as $id => $line) {
                $this->content[$id] = '<p>' . $line . '</p>';
            }
        }
    }

    public function getRealTitle(){
        if($this->title){
            return null;
        }
        foreach ($this->content as $id => $line) {
            if(str_contains($line,'<h1>')){
                unset($this->content[$id]);
                $this->title = str_replace(['<h1>','</h1>'],'', $line);
            }
        }
        if(!$this->title){
            $lastNameIndex = strrpos($this->fileName,'/');
            $completeName = substr($this->fileName,$lastNameIndex);
            $nameAssist = str_replace(array('.txt', '.html', '-'), array('', '', ' '), substr($completeName, 11));
            $this->title = $this->date . ucwords($nameAssist);
        }
    }
}