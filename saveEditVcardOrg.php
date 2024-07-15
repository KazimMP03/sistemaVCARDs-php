<?php
include_once('config.php');

if (isset($_POST['submit'])) {
    $chave = $_POST['chave'];
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $apresentacao = $_POST['apresentacao'];
    $imagem = $_POST['imagem'];
    $categoria = $_POST['categoria'];
    $redes = $_POST['redes'];
    $contato = $_POST['contato'];
    $patrocinadores = $_POST['patrocinadores'];

    $sqlUpdate = "UPDATE vcards 
        SET titulo='$titulo', apresentacao='$apresentacao', imagem='$imagem', categoria='$categoria', redes='$redes', contato='$contato', patrocinadores='$patrocinadores' WHERE id=$id";
    $result = $conexao->query($sqlUpdate);

    // Correção: Utilizando aspas duplas para que a variável seja interpretada
    echo "<script>alert('Vcard Editado Com Sucesso!'); window.location.href='sistOrg.php?page=consultavcardsOrg.php';</script>";
}
echo "<script>alert('ERRO CARAIO!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
