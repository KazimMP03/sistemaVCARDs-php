<?php
session_start();
include_once('config.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}
$logado = $_SESSION['email'];
$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
$id = $_SESSION['id'];

include_once('config.php');

if (isset($_POST['update'])) {
    $id_evento = $_POST['id_evento'];
    $nome = $_POST['nome_evento'];
    $data = $_POST['data_evento'];
    $cidade = $_POST['local'];

    $sqlUpdate = "UPDATE eventos SET nome_evento='$nome', data_evento='$data', endereco_evento='$cidade' WHERE id_evento=$id_evento";
    $result = $conexao->query($sqlUpdate);

    if ($result) {
        echo "<script>alert('Evento Editado Com Sucesso!'); window.location.href='sistAdm.php?page=consultaeventos.php';</script>";
    }
} else {
    // Caso ocorra algum erro durante a edição
    echo "Erro ao editar usuário.";
}
