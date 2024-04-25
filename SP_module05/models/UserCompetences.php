<?php

class UserCompetences extends \config\Dbh
{
    public function getUsersFromJobs($id)
    {
        $sql = "SELECT * FROM jobs LEFT JOIN user_job ON user_job.job_id = jobs.id LEFT JOIN users ON users.id = user_job.user_id WHERE jobs.id = ?";

        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$id]);


        return $stmt->fetchAll();
    }

    public function getCompetencesAndHeight($jobId, $userId)
    {
        $sql = "SELECT 
competences.competence, 
competences.height,
levels.level,
levels.factor,
levels.factor * competences.height AS something
FROM user_compecentes
LEFT JOIN users ON users.id = user_compecentes.user_id
LEFT JOIN jobs ON jobs.id = user_compecentes.job_id
LEFT JOIN levels ON levels.id = user_compecentes.level_id
LEFT JOIN competences ON competences.id = user_compecentes.competence_id
WHERE user_compecentes.job_id = ? 
AND users.id = ?";

        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([$jobId, $userId]);

        return $stmt->fetchAll();

    }



    public function UserAccordion($idJob)
    {
        $users = $this->getUsersFromJobs($idJob);



        foreach ($users as $user) {
            $allCompetencesFromUser = $this->getCompetencesAndHeight($idJob, $user['user_id']);

            $totalValue = 0;
            foreach ($allCompetencesFromUser as $item) {
                $totalValue += $item['something'];
            }



            echo '
            <div class="content-accordion">
            <section class="container-accordion">
             <input type="checkbox" checked id=' . $user['email'] . '>

                <div class="header-accordion">
                    <h2>' . $user['name'] . ' ' . $totalValue . '</h2>
                    <label for=' . $user['email']. '>V</label>
                </div>

                <div class="content-accordion">
                    <h5>Email: ' . $user['email'] . '</h5>
                    <h5>PhoneNumber: ' . $user['phonenumber'] . '</h5>
                    <h3 class="text-competences">Competences Levels</h3>
            
                    ';
                foreach ($allCompetencesFromUser as $item) {
                    echo "<div class='container-row'>
                <h2>" . $item['competence'] . "</h2>
                <h3>" . $item['level'] . "</h3>
            </div>";
                } echo '
                </div>
        </section>
    </div>';

        }


    }

}