<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $arquivo = $_FILES['foto'];

    if ($arquivo['error']) {
        echo "<script>alert('Erro ao carregar a foto!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
        exit;
    }
    if ($arquivo['size'] > 2100000) {
        echo "<script>alert('A foto deve ter no máximo 2mb de tamanho!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
        exit;
    }
    // Obtém as dimensões da imagem
    $dimensoes = getimagesize($arquivo['tmp_name']);
    $largura = $dimensoes[0];
    $altura = $dimensoes[1];

    // Verifica se a imagem é um quadrado
    if ($largura !== $altura) {
        echo "<script>alert('A imagem deve ser um quadrado perfeito largura = altura!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
        exit;
    }
    $pasta = "fotos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if ($extensao != "jpg" && $extensao != 'png') {
        echo "<script>alert('O arquivo da foto deve possuir a extensãp .png ou .jpg!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
        exit;
    }

    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $pasta . $novoNomeDoArquivo . "." . $extensao);

    if ($deu_certo) {
        // Antes de atualizar o banco de dados, exclua o arquivo antigo se existir
        $sqlFotoAntiga = "SELECT foto FROM usuarios WHERE id=$id";
        $resultFotoAntiga = mysqli_query($conexao, $sqlFotoAntiga);

        if ($resultFotoAntiga) {
            $rowFotoAntiga = mysqli_fetch_assoc($resultFotoAntiga);
            $fotoAntiga = $rowFotoAntiga['foto'];

            // Certifique-se de que o arquivo antigo existe antes de excluí-lo
            if (file_exists($fotoAntiga)) {
                unlink($fotoAntiga); // Excluir o arquivo antigo
            }
        }

        $sqlUpdate = "UPDATE usuarios SET foto='$path' WHERE id=$id";
        $result = mysqli_query($conexao, $sqlUpdate);

        if ($result) {
            $_SESSION['foto'] = $path;
            echo "<script>alert('Foto atualizada com sucesso!'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
            exit;
        } else {
            echo "<script>alert('Erro ao carregar a foto! Tente novamente mais tarde.'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
        }
    } else {
        echo "<script>alert('Erro ao carregar a foto! Tente novamente mais tarde.'); window.location.href='sistAdm.php?page=perfilAdm.php';</script>";
    }
}
