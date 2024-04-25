<?php

 $host = "localhost";
 $user = "root";
 $pwd = "";
 $dbName = "module05";


function connect(){
    global $host, $dbName, $user, $pwd;
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;

    $pdo = new \PDO($dsn, $user, $pwd);

    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);



    return $pdo;
}


function close_con($conn){
    exit();
}