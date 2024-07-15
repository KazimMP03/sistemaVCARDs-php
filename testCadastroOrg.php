<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = $_POST['nome'];
    $sexo = $_POST['genero'];
    $data = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    $verifica_email = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email'");
    if (mysqli_num_rows($verifica_email) > 0) {
        echo "<script>alert('Este e-mail já está em uso!'); window.location.href='sistOrg.php?page=cadastroorg.php';</script>";
        exit;
    }

    $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,tipo,sexo,datanasc,cidade,email,senha) VALUES ('$nome','$tipo','$sexo','$data','$cidade','$email','$senha')");

    if ($result) {
        echo "<script>alert('Usuário Cadastrado Com Sucesso!'); window.location.href='sistOrg.php?page=consultausuariosOrg.php';</script>";
        exit;
    } else {
        // Handle the case where the insertion failed
        echo "<script>alert('Erro ao cadastrar usuário!'); window.location.href='sistOrg.php?page=consultausuariosOrg.php';</script>";
        exit;
    }
}
echo "<script>alert('ERRO!'); window.location.href='sistOrg.php?page=consultausuariosOrg.php';</script>";
exit;
