<?php
include 'dbh.class.php';
class Users extends Dbh
{
    protected function getUser($name){
        $sql = "SELECT * FROM users WHERE first_name LIKE ?";

        $stmt = $this->connect()->prepare($sql);

        $stmt->execute(['%' . $name . '%']);


        return $stmt->fetchAll();
    }


    protected function setUser($name, $lastName)
    {
        $sql = "INSERT INTO users(first_name, last_name) values(?,?)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$name, $lastName]);
    }
}