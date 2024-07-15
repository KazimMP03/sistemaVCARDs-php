<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = $_POST['nome'];
    $sexo = $_POST['genero'];
    $data = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $provisorio = $_POST['tipo'];
    $provisorio2 = $_POST['codigo'];

    if ($_POST['tipo'] === 'Visitante') {
        $tipo = 'Visitante';
    } elseif ($_POST['tipo'] === 'Participante' && $_POST['codigo'] === 'participvcard123') {
        $tipo = 'Participante';
        $codigo = $_POST['codigo'];
    } elseif ($_POST['tipo'] === 'Organizador' && $_POST['codigo'] === 'organizvcard123') {
        $tipo = 'Organizador';
        $codigo = $_POST['codigo'];
    } elseif ($_POST['tipo'] === 'Administrador' && $_POST['codigo'] === 'adminvcard123') {
        $tipo = 'Administrador';
        $codigo = $_POST['codigo'];
    } else {
        $redirectURL = 'cadastro.php?mensagem2=' . urlencode('O código informado está incorreto.')
            . '&email=' . urlencode($email) . '&senha=' . urlencode($senha) . '&nome=' . urlencode($nome) . '&cidade=' . urlencode($cidade)
            . '&codigo=' . urlencode($provisorio2) . '&tipo=' . urlencode($provisorio) . '&data_nascimento=' . urlencode($data) . '&genero=' . urlencode($sexo);
        header("Location: $redirectURL");
        exit;
    }

    $verifica_email = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email'");
    if (mysqli_num_rows($verifica_email) > 0) {
        $redirectURL = 'cadastro.php?mensagem=' . urlencode('Este email já está em uso.')
            . '&email=' . urlencode($email) . '&senha=' . urlencode($senha) . '&nome=' . urlencode($nome) . '&cidade=' . urlencode($cidade)
            . '&codigo=' . urlencode($provisorio2) . '&tipo=' . urlencode($provisorio) . '&data_nascimento=' . urlencode($data) . '&genero=' . urlencode($sexo);
        header("Location: $redirectURL");
        exit;
    }

    $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,tipo,sexo,datanasc,cidade,email,senha) VALUES ('$nome','$tipo','$sexo','$data','$cidade','$email','$senha')");

    header('Location: login.php?mensagem=' . urlencode('Conta cadastrada com sucesso!'));
}
