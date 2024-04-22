<?php
//    include 'classes/usersview.class.php';
    include 'classes/userscontr.class.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php

//    $userObj = new UsersView();
//
//    $userObj->showUsers('a');

    $userObj2 = new UsersContr();
    $userObj2->createUser("Jane", "Doe");

?>
</body>
</html>