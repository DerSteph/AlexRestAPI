<?php
function buildPdo() {
    $pdo = new PDO('mysql:host=localhost;dbname=coronaapp', 'coronaapp', 'SmSvQNr0Kc1hxdRW');
    return $pdo;
}
?>