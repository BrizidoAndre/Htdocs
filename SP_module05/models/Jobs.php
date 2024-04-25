<?php

use config\Dbh;

class Jobs extends Dbh
{
    public function getJobs(){
        $query = "SELECT * FROM jobs";

        $stmt = $this->connect()->query($query);

        return $stmt->fetchAll();
    }
}