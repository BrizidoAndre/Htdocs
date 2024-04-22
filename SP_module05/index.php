<?php
/**
 * This is the system landing page
 */

// start a session
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Landing Page</title>

    <!-- Bootstrap core CSS -->
    <link href="include/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="include/styles.css">
    <link href="headers.css" rel="stylesheet">
</head>
<body>

<main>
    <h1>Job Indicator</h1>

    <section class="container-accordion">
        <input type="checkbox" id="Web-designer">

        <div class="header-accordion">
            <h2>Web Designer</h2>
            <label for="Web-designer">V</label>
        </div>

        <div class="content-accordion">
            <h3 class="text-competences">Competences Levels</h3>

            <form action="">
                <div class="container-select">
                    <select name="" id="">
                        <option value="" selected hidden>Selecione um valor</option>
                        <option value="teste">Teste</option>
                        <option value="testado">Testado</option>
                    </select>
                    <h4>Descrition</h4>
                </div>

                <input type="text" required placeholder="Username...">

                <div class="container-input">
                    <input type="email" required placeholder="Insira um email válido">
                    <input type="tel" placeholder="Número...">
                </div>

                <button>Save</button>
            </form>

        </div>
    </section>
</main>


<script src="include/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
