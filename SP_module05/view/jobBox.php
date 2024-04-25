<?php

require './models/Jobs.php';
require './models/Competences.php';

class jobBox
{
    public function loadJobBoxes()
    {
        $jobs = new Jobs();
        $competence = new Competences();

        foreach ($jobs->getJobs() as $allJob) {

            echo '<section class="container-accordion">
        <input type="checkbox" checked id=' . $allJob['id'] . '>

        <div class="header-accordion">
            <h2>' . $allJob['job'] . '</h2>
            <label for=' . $allJob['id'] . '>V</label>
        </div>

        <div class="content-accordion">
            <h3 class="text-competences">Competences Levels</h3>

            <form method="post" action="controllers/FormHandler.php">';

            $competence->loadTitleCompetences($allJob);

            echo '<input type="text" name="username" required placeholder="Username...">

                <div class="container-input">
                    <input type="email" name="email" required placeholder="Insira um email válido">
                    <input type="tel" name="number" placeholder="Número...">
                    <input value='. $allJob['id'] . ' name="job_id" style="display: none">
                    
                </div>

                <button>Save</button>
            </form>


        </div>
    </section>';
        }
    }

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
