<?php

use config\Dbh;

class Competences extends Dbh
{

    protected function getCompetences($id){

        $query  = "SELECT * FROM competences WHERE job_id = ?";

        $stmt = $this->connect()->prepare($query);

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function loadTitleCompetences($job){
        $results = $this->getCompetences($job['id']);

        foreach ($results as $competence) {
            echo "<div class='container-select'>
                    <select required name='" . $competence['id'] ."' id=''>
                        <option value='' selected hidden>Selecione um valor</option>
                        <option value='1'>Nenhum</option>
                        <option value='2'>Iniciante</option>
                        <option value='3'>Completo</option>
                        <option value='4'>Especialista</option>
                    </select>
                    <h4>" . $competence['competence'] . "</h4>
                </div>";
        }

    }

}