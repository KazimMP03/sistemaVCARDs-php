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

// Recebe dados do formulario de cadastro de evento
if (isset($_POST['submit'])) {

    include_once('config.php');

    $idcriador = $id;
    $nomecriador = $nome;
    $chave = generateUniqueRandomString(15, $conexao); // Função para gerar chave única
    $dataevento = $_POST['data_evento'];
    $nomeevento = $_POST['nome_evento'];
    $localevento = $_POST['endereco_evento'];

    $result = mysqli_query($conexao, "INSERT INTO eventos(id_criador, nome_criador, chave, data_evento, nome_evento, endereco_evento) VALUES ('$idcriador', '$nomecriador', '$chave', '$dataevento', '$nomeevento', '$localevento')");

    $result_vcards_insert = mysqli_query($conexao, "INSERT INTO vcards(chave, titulo, data_pub, id_proprietario, data_vcard, nome_proprietario) VALUES ('$chave', '$nomeevento', DATE_FORMAT(NOW(), '%Y-%m-%d'), '$id', '$dataevento', '$nomecriador')");

    $idvcard = mysqli_insert_id($conexao);

    echo "<script>alert('Evento Criado Com Sucesso! Favor criar o VCARD do Evento!'); window.location.href='sistAdm.php?page=editvcardev.php?id=$idvcard';</script>";
}

function generateUniqueRandomString($length = 15, $conexao)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';

    do {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Verifica se a chave já existe no banco de dados
        $query = "SELECT COUNT(*) as count FROM eventos WHERE chave = '$randomString'";
        $result = mysqli_query($conexao, $query);
        $row = mysqli_fetch_assoc($result);
        $keyExists = $row['count'] > 0;
    } while ($keyExists);

    return $randomString;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="fundo">
        <a href="sistAdm.php?page=consultaeventos.php" class="retbtn" title="Voltar"><i class='bx bxs-chevrons-left'></i></a>
        <div class="tablesuser">

            <form id="editForm" action="cadastroevento.php" method="POST">
                <table class='user-table'>
                    <tr>
                        <td class='label special-label'>NOME</td>
                        <td class='value5'>
                            <label for='nome' class='nome-label'>Nome</label>
                            <input type='text' name='nome_evento' id='nome' required>

                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>ENDEREÇO DO EVENTO</td>
                        <td class='value2'>
                            <label for='cidade' class='cidade-label'>Endereço</label>
                            <input type='text' name='endereco_evento' id='cidade' required>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>DATA DO EVENTO</td>
                        <td class='value7'>
                            <input type='date' name='data_evento' id='data_nascimento' required>
                        </td>
                    </tr>

                </table>
                <button type="submit" name="submit" id="updateButton" style="display: none;"></button>

            </form>
        </div>
        <div>
            <a href="#" class="editbtn" id="submitFormLink" title="Salvar"><i class='bx bx-check-circle'></i></a>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            var inputCidade = $('#cidade');
            var inputEmail = $('#email');
            var inputSenha = $('#senha');
            var inputNome = $('#nome');
            var labelEmail = $('.email-label');
            var labelSenha = $('.senha-label');
            var labelNome = $('.nome-label');
            var labelCidade = $('.cidade-label');
            var value3input = $('.value3 input');
            var value2input = $('.value2 input');
            var value4input = $('.value4 input');
            var value5input = $('.value5 input');
            var cidadeOriginal = 'Cidade';
            var emailOriginal = 'Email';
            var senhaOriginal = 'Senha';
            var nomeOriginal = 'Nome';

            // Adicione um ouvinte de evento para o foco no input
            inputCidade.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputCidade.val('');
                labelCidade.css('top', '-8px');
                labelCidade.css('font-size', '12px');
                labelCidade.css('color', '#9a4dff');
                value2input.css('color', '#707070');
            });
            inputEmail.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputEmail.val('');
                labelEmail.css('top', '-8px');
                labelEmail.css('font-size', '12px');
                labelEmail.css('color', '#9a4dff');
                value3input.css('color', '#707070');
            });
            inputSenha.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputSenha.val('');
                labelSenha.css('top', '-8px');
                labelSenha.css('font-size', '12px');
                labelSenha.css('color', '#9a4dff');
                value4input.css('color', '#707070');
            });
            inputNome.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputNome.val('');
                labelNome.css('top', '-8px');
                labelNome.css('font-size', '12px');
                labelNome.css('color', '#9a4dff');
                value5input.css('color', '#707070');
            });

            // Adicione um ouvinte de evento para perder o foco no input
            inputCidade.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputCidade.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputCidade.val('');
                    labelCidade.css('top', '9px');
                    labelCidade.css('font-size', '16px');
                    labelCidade.css('color', 'rgb(165, 165, 165)');
                    value2input.css('color', '#fff');
                }
            });
            inputEmail.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputEmail.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputEmail.val('');
                    labelEmail.css('top', '9px');
                    labelEmail.css('font-size', '16px');
                    labelEmail.css('color', 'rgb(165, 165, 165)');
                    value3input.css('color', '#fff');
                }
            });
            inputSenha.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputSenha.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputSenha.val('');
                    labelSenha.css('top', '9px');
                    labelSenha.css('font-size', '16px');
                    labelSenha.css('color', 'rgb(165, 165, 165)');
                    value4input.css('color', '#fff');
                }
            });
            inputNome.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputNome.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputNome.val('');
                    labelNome.css('top', '9px');
                    labelNome.css('font-size', '16px');
                    labelNome.css('color', 'rgb(165, 165, 165)');
                    value5input.css('color', '#fff');
                }
            });
        });

        // Define a variável com o valor desejado
        var perfilText = "Criar Evento";

        // Envia a variável para a página pai (sistAdm.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        document.getElementById('submitFormLink').addEventListener('click', function() {
            document.getElementById('updateButton').click();
        });
    </script>

</html>