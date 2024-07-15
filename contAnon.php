<?php
include_once('config.php');
$id = '1';
$query = "UPDATE anonimos SET contador = contador + 1 WHERE id = $id";
$result = $conexao->query($query);

if (!$result) {
    die('ERRO: ' . $conexao->error);
}
header('Location: sistAnon.php');
