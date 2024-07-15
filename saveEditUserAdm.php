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


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['genero'];
    $data = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o novo e-mail já existe no banco de dados, excluindo o e-mail do usuário logado
    $sqlCheckEmail = "SELECT id FROM usuarios WHERE email='$email' AND id != $id";
    $resultCheckEmail = $conexao->query($sqlCheckEmail);

    if ($resultCheckEmail->num_rows > 0) {

        if ($tipo == "Administrador") {
            // Se encontrar um e-mail duplicado, redireciona para a página editperfil.php com um alerta
            echo "<script>alert('Este e-mail já possui outro cadastro! Digite outro e-mail.'); window.location.href='sistAdm.php?page=editadm.php?id=$id';</script>";
            exit();
        }
        echo "<script>alert('Este e-mail já possui outro cadastro! Digite outro e-mail.'); window.location.href='sistOrg.php?page=editorg.php?id=$id';</script>";
        exit();
    }

    $sqlUpdate = "UPDATE usuarios SET nome='$nome', sexo='$sexo', datanasc='$data', cidade='$cidade', email='$email', senha='$senha' WHERE id=$id";
    $result = $conexao->query($sqlUpdate);

    if ($result) {

        if ($tipo == "Administrador") {
            // Se encontrar um e-mail duplicado, redireciona para a página editperfil.php com um alerta
            echo "<script>alert('Usuário Editado Com Sucesso!'); window.location.href='sistAdm.php?page=consultausuarios.php';</script>";
            exit();
        }
        echo "<script>alert('Usuário Editado Com Sucesso!'); window.location.href='sistOrg.php?page=consultausuariosOrg.php';</script>";
        exit();
    }
} else {
    // Caso ocorra algum erro durante a edição
    echo "Erro ao editar usuário.";
}
