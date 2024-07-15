<?php
session_start();
include_once('config.php');

$logado = $_SESSION['email'];
$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
$id = $_SESSION['id'];

if (!empty($_GET['id'])) {
    include_once('config.php');

    $id_vcard = $_GET['id'];

    $sqlSelect = "SELECT *  FROM vcards WHERE id=$id_vcard";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM vcards WHERE id=$id_vcard";
        $resultDelete = $conexao->query($sqlDelete);
        $sqlDelete = "DELETE FROM vcards_favoritos WHERE id_usuario = '$id' AND id_vcard = '$id_vcard'";
        $resultDelete = $conexao->query($sqlDelete);
        $sqlDelete = "DELETE FROM vcards_likes WHERE id_usuario = '$id' AND id_vcard = '$id_vcard'";
        $resultDelete = $conexao->query($sqlDelete);
        echo "<script>alert('Vcard Deletado Com Sucesso!'); window.location.href='sistOrg.php?page=consultavcardsOrg.php';</script>";
        exit;
    }
}

// Redireciona para sistAdm.php com a indicação para carregar consulta.php
header('Location: sistAdm.php?page=consultavcards.php');
