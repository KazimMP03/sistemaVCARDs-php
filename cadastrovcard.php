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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="fundo">
        <a href="sistAdm.php?page=consultavcards.php" class="retbtn" title="Voltar"><i class='bx bxs-chevrons-left'></i></a>
        <div class="tablesuser">

            <form id="editForm" action="testCadastroVcard.php" method="POST">
                <table class='user-table'>

                    <tr>
                        <td class='label special-label'>CHAVE</td>
                        <td class='value2'>
                            <label for='chave' class='chave-label'>Chave do Evento</label>
                            <input type='text' name='chave' id='chave' value='' required>
        </div>
        </td>
        </tr>

        <tr>
            <td class='label special-label'>TITULO</td>
            <td class='value3'>
                <label for='titulo' class='titulo-label'>Título do Vcard</label>
                <input type='text' name='titulo' id='titulo' value='' required>
    </div>
    </td>
    </tr>

    <tr>
        <td class='label special-label'>INFOS / LOCAL</td>
        <td class='value4'>
            <label for='apresentacao' class='apresentacao-label'>Informações Gerais</label>
            <input type='text' name='apresentacao' id='apresentacao' value='' required>
            </div>
        </td>
    </tr>


    <tr>
        <td class='label special-label'>CATEGORIA</td>
        <td class='value9'>
            <label for='categoria' class='categoria-label'>Categoria do Vcard</label>
            <input type='text' name='categoria' id='categoria' value='' required>
            </div>
        </td>
    </tr>

    <tr>
        <td class='label special-label'>REDES SOCIAIS</td>
        <td class='value10'>
            <label for='redes' class='redes-label'>Redes Sociais</label>
            <input type='text' name='redes' id='redes' value='' required>
            </div>
        </td>
    </tr>

    <tr>
        <td class='label special-label'>CONTATO</td>
        <td class='value11'>
            <label for='contato' class='contato-label'>Informação de Contato</label>
            <input type='text' name='contato' id='contato' value='' required>
            </div>
        </td>
    </tr>
    <tr>
        <td class='label special-label'>PATROCINADORES</td>
        <td class='value12'>
            <label for='patrocinadores' class='patrocinadores-label'>Patrocinadores</label>
            <input type='text' name='patrocinadores' id='patrocinadores' value='' required>
            </div>
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
            var inputChave = $('#chave');
            var inputTitulo = $('#titulo');
            var inputApresentacao = $('#apresentacao');
            var inputImagem = $('#imagem');
            var inputCategoria = $('#categoria');
            var inputRedes = $('#redes');
            var inputContato = $('#contato');
            var inputPatrocinadores = $('#patrocinadores');
            var labelChave = $('.chave-label');
            var labelTitulo = $('.titulo-label');
            var labelApresentacao = $('.apresentacao-label');
            var labelImagem = $('.imagem-label');
            var labelCategoria = $('.categoria-label');
            var labelRedes = $('.redes-label');
            var labelContato = $('.contato-label');
            var labelPatrocinadores = $('.patrocinadores-label');
            var value2input = $('.value2 input');
            var value3input = $('.value3 input');
            var value4input = $('.value4 input');
            var value8input = $('.value8 input');
            var value9input = $('.value9 input');
            var value10input = $('.value10 input');
            var value11input = $('.value11 input');
            var value12input = $('.value12 input');
            var chaveOriginal = 'Chave';
            var tituloOriginal = 'Titulo';
            var apresentacaoOriginal = 'Apresentação';
            var imagemOriginal = 'Imagem';
            var categoriaOriginal = 'Categoria';
            var redesOriginal = 'Redes';
            var contatoOriginal = 'Contato';
            var patrocinadoresOriginal = 'Patrocinadores';

            // Adicione um ouvinte de evento para o foco no input
            inputChave.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputChave.val('');
                labelChave.css('top', '-8px');
                labelChave.css('font-size', '12px');
                labelChave.css('color', '#9a4dff');
                value2input.css('color', '#707070');
            });
            inputTitulo.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputTitulo.val('');
                labelTitulo.css('top', '-8px');
                labelTitulo.css('font-size', '12px');
                labelTitulo.css('color', '#9a4dff');
                value3input.css('color', '#707070');
            });
            inputApresentacao.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputApresentacao.val('');
                labelApresentacao.css('top', '-8px');
                labelApresentacao.css('font-size', '12px');
                labelApresentacao.css('color', '#9a4dff');
                value4input.css('color', '#707070');
            });
            inputImagem.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputImagem.val('');
                labelImagem.css('top', '-8px');
                labelImagem.css('font-size', '12px');
                labelImagem.css('color', '#9a4dff');
                value8input.css('color', '#707070');
            });
            inputCategoria.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputCategoria.val('');
                labelCategoria.css('top', '-8px');
                labelCategoria.css('font-size', '12px');
                labelCategoria.css('color', '#9a4dff');
                value9input.css('color', '#707070');
            });
            inputRedes.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputRedes.val('');
                labelRedes.css('top', '-8px');
                labelRedes.css('font-size', '12px');
                labelRedes.css('color', '#9a4dff');
                value10input.css('color', '#707070');
            });
            inputContato.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputContato.val('');
                labelContato.css('top', '-8px');
                labelContato.css('font-size', '12px');
                labelContato.css('color', '#9a4dff');
                value11input.css('color', '#707070');
            });
            inputPatrocinadores.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputPatrocinadores.val('');
                labelPatrocinadores.css('top', '-8px');
                labelPatrocinadores.css('font-size', '12px');
                labelPatrocinadores.css('color', '#9a4dff');
                value12input.css('color', '#707070');
            });

            // Adicione um ouvinte de evento para perder o foco no input
            inputChave.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputChave.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputChave.val('');
                    labelChave.css('top', '9px');
                    labelChave.css('font-size', '16px');
                    labelChave.css('color', 'rgb(165, 165, 165)');
                    value2input.css('color', '#fff');
                }
            });
            inputTitulo.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputTitulo.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputTitulo.val('');
                    labelTitulo.css('top', '9px');
                    labelTitulo.css('font-size', '16px');
                    labelTitulo.css('color', 'rgb(165, 165, 165)');
                    value3input.css('color', '#fff');
                }
            });
            inputApresentacao.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputApresentacao.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputApresentacao.val('');
                    labelApresentacao.css('top', '9px');
                    labelApresentacao.css('font-size', '16px');
                    labelApresentacao.css('color', 'rgb(165, 165, 165)');
                    value4input.css('color', '#fff');
                }
            });
            inputImagem.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputImagem.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputImagem.val('');
                    labelImagem.css('top', '9px');
                    labelImagem.css('font-size', '16px');
                    labelImagem.css('color', 'rgb(165, 165, 165)');
                    value8input.css('color', '#fff');
                }
            });
            inputCategoria.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputCategoria.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputCategoria.val('');
                    labelCategoria.css('top', '9px');
                    labelCategoria.css('font-size', '16px');
                    labelCategoria.css('color', 'rgb(165, 165, 165)');
                    value9input.css('color', '#fff');
                }
            });
            inputRedes.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputRedes.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputRedes.val('');
                    labelRedes.css('top', '9px');
                    labelRedes.css('font-size', '16px');
                    labelRedes.css('color', 'rgb(165, 165, 165)');
                    value10input.css('color', '#fff');
                }
            });
            inputContato.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputContato.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputContato.val('');
                    labelContato.css('top', '9px');
                    labelContato.css('font-size', '16px');
                    labelContato.css('color', 'rgb(165, 165, 165)');
                    value11input.css('color', '#fff');
                }
            });
            inputPatrocinadores.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputPatrocinadores.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputPatrocinadores.val('');
                    labelPatrocinadores.css('top', '9px');
                    labelPatrocinadores.css('font-size', '16px');
                    labelPatrocinadores.css('color', 'rgb(165, 165, 165)');
                    value12input.css('color', '#fff');
                }
            });
        });

        // Define a variável com o valor desejado
        var perfilText = "CRIAÇÃO VCARD";

        // Envia a variável para a página pai (sistAdm.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        document.getElementById('submitFormLink').addEventListener('click', function() {
            document.getElementById('updateButton').click();
        });

        function idTipo() {
            <?php
            // Verifica o tipo do usuário e redireciona de acordo
            switch ($tipo) {
                case 'Administrador':
                    echo 'window.location.href = "sistAdm.php?page=perfilAdm.php";';
                    break;
                case 'Organizador':
                    echo 'window.location.href = "sistOrg.php?page=dashboardOrg.php";';
                    break;
                case 'Participante':
                    echo 'window.location.href = "sistPart.php?page=dashboardPart.php";';
                    break;
                case 'Visitante':
                    echo 'window.location.href = "sistVisit.php?page=dashboardVisit.php";';
                    break;
                default:
                    // Redirecionamento padrão, caso o tipo não seja reconhecido
                    echo 'window.location.href = "sistPart.php";';
            }
            ?>
        }
    </script>

</html>