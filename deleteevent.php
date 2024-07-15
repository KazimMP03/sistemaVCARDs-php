<?php
if (!empty($_GET['id_evento'])) {
    include_once('config.php');

    $id_evento = $_GET['id_evento'];

    $sqlSelect = "SELECT *  FROM eventos WHERE id_evento=$id_evento";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM eventos WHERE id_evento=$id_evento";
        $resultDelete = $conexao->query($sqlDelete);
        echo "<script>alert('Evento Deletado Com Sucesso!'); window.location.href='sistAdm.php?page=consultaeventos.php';</script>";
        exit;
    }
}

// Redireciona para sistAdm.php com a indicação para carregar consulta.php
header('Location: sistAdm.php?page=consultaeventos.php');
