<?php

include '../config/connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = connect();

    $username = htmlspecialchars($_POST['username']);

    $email = $_POST['email'];

    $job_id = $_POST['job_id'];

    isset($_POST['number']) ? $phone = htmlspecialchars($_POST['number']) : $phone = null;


    unset($_POST['username'], $_POST['email'], $_POST['number'], $_POST['job_id']);

    if ($phone) {
        $sql = "INSERT INTO users(email,name,phonenumber) VALUES (?,?,?)";

        $stmt = $con->prepare($sql);

        $stmt->execute([$email,$username, $phone]);
    }
    else{
        $sql = "INSERT INTO users(email,name) VALUES (?,?)";

        $stmt = $con->prepare($sql);

        $stmt->execute([$email,$username]);
    }
    $competencesId = array_keys($_POST);

    $levelId = array_values($_POST);

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $con->prepare($sql);

    $stmt->execute([$email]);
    $user = $stmt->fetch();

    $sql = "INSERT INTO user_job VALUES(?,?)";
    $stmt = $con->prepare($sql);
    $stmt->execute([$user['id'], $job_id]);


    for ($i = 0, $iMax = count($_POST); $i < $iMax; $i++) {
        $sql = "INSERT INTO user_compecentes(user_id,job_id,competence_id,level_id) VALUES (?,?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$user['id'], $job_id, $competencesId[$i], $levelId[$i]]);
    }

    echo 'não foi';
    header("Location: http://localhost/SP_module05/index.php");
    die();
}
