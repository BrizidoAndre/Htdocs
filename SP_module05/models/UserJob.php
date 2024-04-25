<?php

namespace models;

use config\Dbh;

include 'config/Dbh.php';
class UserJob extends Dbh
{
    public function PostUser($username, $email, $phone=false){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);

        $result = $stmt->fetch();

        return $result;
    }

}