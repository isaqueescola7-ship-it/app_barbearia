<?php
$hostname = "localhost";
$bancodedados = "barbearia"; // Alterado para o nome correto que aparece no teu phpMyAdmin
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

if ($mysqli->connect_errno) {
    die("Falha ao ligar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
?>