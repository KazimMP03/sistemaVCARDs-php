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

if (isset($_POST['submit'])) {
    include_once('config.php');

    $chave = $_POST['chave'];
    $titulo = $_POST['titulo'];
    $informacoes = $_POST['apresentacao'];
    $imagem = $_POST['imagem'];
    $categoria = $_POST['categoria'];
    $redes = $_POST['redes'];
    $contato = $_POST['contato'];
    $patrocinadores = $_POST['patrocinadores'];

    // Check if $chave exists in the "eventos" table
    $checkChaveQuery = "SELECT chave FROM eventos WHERE chave = '$chave'";
    $checkChaveResult = mysqli_query($conexao, $checkChaveQuery);

    if (mysqli_num_rows($checkChaveResult) > 0) {
        // $chave exists, proceed with the Vcard insertion
        $insertQuery = "INSERT INTO vcards(chave,titulo,apresentacao,imagem,categoria,redes,contato,patrocinadores,data_pub,id_proprietario,nome_proprietario,data_vcard) VALUES ('$chave','$titulo','$informacoes','$imagem','$categoria','$redes','$contato','$patrocinadores', NOW(), '$id', '$nome', 
        (SELECT data_evento FROM eventos WHERE chave = '$chave'))";

        $result = mysqli_query($conexao, $insertQuery);

        if ($result) {
            echo "<script>alert('Vcard Cadastrado Com Sucesso!'); window.location.href='sistAdm.php?page=consultavcards.php';</script>";
            exit;
        } else {
            // Handle the case where the insertion failed
            echo "<script>alert('Erro ao cadastrar Vcard!'); window.location.href='sistAdm.php?page=consultavcards.php';</script>";
            exit;
        }
    } else {
        // $chave does not exist, redirect back to cadastrovcard.php with input values
        $urlParams = "chave=" . urlencode($chave) . "&titulo=" . urlencode($titulo) . "&apresentacao=" . urlencode($informacoes) . "&imagem=" . urlencode($imagem) . "&categoria=" . urlencode($categoria) . "&redes=" . urlencode($redes) . "&contato=" . urlencode($contato) . "&patrocinadores=" . urlencode($patrocinadores);

        echo "<script>alert('Esta Chave de Evento não está associada a nenhum Evento!');";
        echo "window.location.href='sistAdm.php?page=cadastrovcard.php?$urlParams';</script>";
        exit;
    }
}

echo "<script>alert('ERRO!'); window.location.href='sistAdm.php?page=consultaVcards.php';</script>";
exit;
