<?php

// Inicia sessão
session_start();

// Inclui configuração de BD
include_once('config.php');

// Obtém o valor de id_vcard da requisição Ajax
$id_vcard = isset($_POST['id_vcard']) ? $_POST['id_vcard'] : null;

// Verifica se o id_vcard está definido
if ($id_vcard !== null) {
    // Atualiza a contagem de compartilhamentos na tabela "vcards"
    $update_compartilhamentos_sql = "UPDATE vcards SET compartilhamentos = compartilhamentos + 1 WHERE id = '$id_vcard'";
    $update_compartilhamentos_result = $conexao->query($update_compartilhamentos_sql);

    if ($update_compartilhamentos_result) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'ID do vcard não fornecido.';
}
