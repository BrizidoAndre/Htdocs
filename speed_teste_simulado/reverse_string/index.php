<?php
$string = $_POST['reverse'] ?? null;
$string = strtoupper(strrev($string));

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reverse-String</title>
</head>
<body>
<fieldset>
    <legend><label for="reverse">Enter a string</label></legend>
    <form method="post" id="reverse-string">
        <input type="text" id="reverse" name="reverse" required>
        <button>Submit</button>

        <h1 class="resposta"></h1>
    </form>
</fieldset>
<script>
    let form = document.getElementById('reverse-string');
    const input = document.querySelector('input[name=reverse]')
    const resposta = document.querySelector('.resposta')


    form.onsubmit = async (ev) => {
        ev.preventDefault();

        const form = new FormData();
        form.append('reverse', input.value);
        const res = await fetch('http://localhost/speed_teste_simulado/reverse_string/Generate.php?reverse=' + input.value, {
            method: 'POST',
            body: form
        })

        const data = await res.text()

        resposta.innerHTML = data
    }
</script>
</body>
</html>