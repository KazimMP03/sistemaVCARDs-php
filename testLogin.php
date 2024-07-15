<?php
session_start();

if (isset($_POST['email']) && isset($_POST['senha'])) {
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' and senha = '$senha'";

    $result = $conexao->query($sql);

    if (mysqli_num_rows($result) < 1) {
        $redirectURL = 'login.php?mensagem=' . urlencode('Email ou Senha inválidos!')
            . '&email=' . urlencode($email) . '&senha=' . urlencode($senha);
        header("Location: $redirectURL");
    } else {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['tipo'] = $row['tipo'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['foto'] = $row['foto'];

        if ($row['tipo'] == 'Administrador') {
            header('Location: sistAdm.php');
        } else if ($row['tipo'] == 'Organizador') {
            header('Location: sistOrg.php');
        } else if ($row['tipo'] == 'Participante') {
            header('Location: sistPart.php');
        } else if ($row['tipo'] == 'Visitante') {
            header('Location: sistVisit.php');
        } else {
            header('Location: login.php');
        }
    }
} else {

    header('Location: login.php');
}
