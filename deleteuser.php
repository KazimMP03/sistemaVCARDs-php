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

if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $sqlSelect = "SELECT *  FROM usuarios WHERE id=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM usuarios WHERE id=$id";
        $resultDelete = $conexao->query($sqlDelete);
        if ($tipo == "Administrador") {
            echo "<script>alert('Usuário Deletado Com Sucesso!'); window.location.href='sistAdm.php?page=consultausuarios.php';</script>";
            exit;
        }
        echo "<script>alert('Usuário Deletado Com Sucesso!'); window.location.href='sistOrg.php?page=consultausuariosOrg.php';</script>";
        exit;
    }
}

// Redireciona para sistAdm.php com a indicação para carregar consulta.php
header('Location: sistAdm.php?page=consultausuarios.php');
