<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['id_cliente']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$id_barbeiro = intval($_POST['id_barbeiro']);
$id_servico = intval($_POST['id_servico']);
$data_agendamento = $_POST['data_agendamento'];
$horario = $_POST['horario'];

$data_hora_completa = $data_agendamento . " " . $horario;

// Query ajustada para as tuas colunas: id_cliente, id_barbeiro, id_servico, data_hora
$sql = "INSERT INTO agendamento (id_cliente, id_barbeiro, id_servico, data_hora) 
        VALUES ('$id_cliente', '$id_barbeiro', '$id_servico', '$data_hora_completa')";

if ($mysqli->query($sql)) {
    header("Location: index.php?sucesso=1");
} else {
    header("Location: index.php?erro=1");
}
exit();
?>