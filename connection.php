<?php
$mysqli = new mysqli('localhost', 'root', null, 'carbajal');
if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
}
