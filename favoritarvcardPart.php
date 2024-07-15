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

// Verifica se o parâmetro id_vcard foi passado na URL
if (isset($_GET['id'])) {
    $id_vcard = $_GET['id'];

    // Consulta para obter o título e a data do vcard
    $consulta_vcard = "SELECT titulo, data_vcard FROM vcards WHERE id = '$id_vcard'";
    $consulta_result = $conexao->query($consulta_vcard);

    if ($consulta_result->num_rows > 0) {
        $row = $consulta_result->fetch_assoc();
        $titulo_vcard = $row['titulo'];
        $data_vcard = $row['data_vcard'];

        // Verifica se já existe uma entrada na tabela vcards_favoritos com os mesmos valores
        $verificar_sql = "SELECT * FROM vcards_favoritos WHERE id_usuario = '$id' AND id_vcard = '$id_vcard'";
        $verificar_result = $conexao->query($verificar_sql);

        if ($verificar_result->num_rows > 0) {
            // Se já existir, exclui a entrada
            $excluir_sql = "DELETE FROM vcards_favoritos WHERE id_usuario = '$id' AND id_vcard = '$id_vcard'";
            $excluir_result = $conexao->query($excluir_sql);

            if (!$excluir_result) {
                die('Erro ao excluir o vcard da lista de favoritos: ' . $conexao->error);
            }

            // Atualiza o contador na tabela vcards
            $atualizar_contador_sql = "UPDATE vcards SET favoritado = favoritado - 1 WHERE id = '$id_vcard'";
            $atualizar_contador_result = $conexao->query($atualizar_contador_sql);

            if (!$atualizar_contador_result) {
                die('Erro ao atualizar o contador na tabela vcards: ' . $conexao->error);
            }

            // Redireciona para a página editvcard.php com uma mensagem
            echo "<script>alert('Este Vcard foi desfavoritado da sua lista!'); window.location.href='sistPart.php?page=showvcardPart.php?id=$id_vcard';</script>";
            exit;
        } else {
            // Se não existir, adiciona o registro na tabela vcards_favoritos
            $favoritar_sql = "INSERT INTO vcards_favoritos (id_usuario, id_vcard, titulo_vcard, data_vcard) VALUES ('$id', '$id_vcard', '$titulo_vcard', '$data_vcard')";
            $favoritar_result = $conexao->query($favoritar_sql);

            if (!$favoritar_result) {
                die('Erro ao favoritar o vcard: ' . $conexao->error);
            }

            // Atualiza o contador na tabela vcards
            $atualizar_contador_sql = "UPDATE vcards SET favoritado = favoritado + 1 WHERE id = '$id_vcard'";
            $atualizar_contador_result = $conexao->query($atualizar_contador_sql);

            if (!$atualizar_contador_result) {
                die('Erro ao atualizar o contador na tabela vcards: ' . $conexao->error);
            }

            // Redireciona para a página favoritos.php
            echo "<script>alert('Este Vcard foi adicionado à sua lista de favoritos!'); window.location.href='sistPart.php?page=favoritosPart.php';</script>";
            exit;
        }
    } else {
        // Se não encontrar o vcard com o ID fornecido
        echo 'Vcard não encontrado.';
    }
} else {
    // Se o id_vcard não estiver definido na URL, redireciona para uma página de erro ou exibe uma mensagem
    echo 'ID do vcard não fornecido.';
}
