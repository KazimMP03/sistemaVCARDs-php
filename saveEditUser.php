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
    $tipo = $_POST['tipo'];
    $sexo = $_POST['genero'];
    $data = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o novo e-mail já existe no banco de dados, excluindo o e-mail do usuário logado
    $sqlCheckEmail = "SELECT id FROM usuarios WHERE email='$email' AND id != $id";
    $resultCheckEmail = $conexao->query($sqlCheckEmail);

    if ($resultCheckEmail->num_rows > 0) {
        switch ($tipo) {
            case 'Administrador':
                echo "<script>alert('Este e-mail já possui outro cadastro! Digite outro e-mail.'); window.location.href='sistAdm.php?page=editperfil.php?id=$id';</script>";
                exit();
            case 'Organizador':
                echo "<script>alert('Este e-mail já possui outro cadastro! Digite outro e-mail.'); window.location.href='sistOrg.php?page=editperfil.php?id=$id';</script>";
                exit();
            case 'Participante':
                echo "<script>alert('Este e-mail já possui outro cadastro! Digite outro e-mail.'); window.location.href='sistPart.php?page=editperfil.php?id=$id';</script>";
                exit();
            case 'Visitante':
                echo "<script>alert('Este e-mail já possui outro cadastro! Digite outro e-mail.'); window.location.href='sistVisit.php?page=editperfil.php?id=$id';</script>";
                exit();
            default:
                // Redirecionamento padrão, caso o tipo não seja reconhecido
                header('Location: login.php');
        }
    }

    // Se o e-mail não estiver duplicado, realiza a atualização no banco de dados
    $sqlUpdate = "UPDATE usuarios SET nome='$nome', sexo='$sexo', datanasc='$data', cidade='$cidade', email='$email', senha='$senha' WHERE id=$id";
    $result = $conexao->query($sqlUpdate);

    if ($result) {
        $_SESSION['nome'] = $nome; // Armazena o novo valor do nome na sessão

        switch ($tipo) {
            case 'Administrador':
                echo "<script>alert('Perfil Modificado Com Sucesso!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
                break;
            case 'Organizador':
                echo "<script>alert('Perfil Modificado Com Sucesso!'); window.location.href='sistOrg.php?page=perfilOrg.php';</script>";
                break;
            case 'Participante':
                echo "<script>alert('Perfil Modificado Com Sucesso!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
                break;
            case 'Visitante':
                echo "<script>alert('Perfil Modificado Com Sucesso!'); window.location.href='sistVisit.php?page=perfilVisit.php';</script>";
                break;
            default:
                // Redirecionamento padrão, caso o tipo não seja reconhecido
                header('Location: login.php');
        }
    } else {
        // Caso ocorra algum erro durante a edição
        echo "Erro ao editar usuário.";
    }
} else {
    // Caso a requisição não seja válida
    header('Location: login.php');
}
