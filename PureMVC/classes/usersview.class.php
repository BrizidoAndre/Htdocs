<?php
include 'users.class.php';
class UsersView extends Users
{
    public function showUsers($name){
        $results = $this->getUser($name);

        foreach ($results as $result) {
            echo "Full name: " . $result['first_name'] . ' ' . $result['last_name'] . "<br>";
            echo "Possible Nickname: " . $result['first_name'][0] . $result['last_name'][0] . "<br>";

        }
    }

}