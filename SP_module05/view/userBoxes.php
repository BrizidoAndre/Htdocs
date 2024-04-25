<?php

require '../models/Jobs.php';
require '../models/UserCompetences.php';

class UserBoxes
{


    public function loadEmployeesBoxes()
    {
        $jobs = new Jobs();
        $userCompetence = new UserCompetences();

        foreach ($jobs->getJobs() as $allJob) {

            echo '<section class="container-accordion">
        <input type="checkbox" checked id=' . $allJob['job'] . '>

        <div class="header-accordion">
            <h2>' . $allJob['job'] . '</h2>
            <label for=' . $allJob['job'] . '>V</label>
        </div>

        
';

            $userCompetence->UserAccordion($allJob['id']);

            echo '
    </section>';
        }
    }

}
