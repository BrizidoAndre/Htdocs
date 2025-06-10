<?php
$a = $_POST['reverse']??'não foi';

function mb_strrev($string){
    return mb_strtoupper(implode('',array_reverse(mb_str_split($string))));
}

echo mb_strrev($a);