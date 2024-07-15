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

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sqlSelect = "SELECT * FROM vcards WHERE id=$id";
    $result = $conexao->query($sqlSelect);
    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            $chave = $user_data['chave'];
            $titulo = $user_data['titulo'];
            $apresentacao = $user_data['apresentacao'];
            $imagem = $user_data['imagem'];
            $categoria = $user_data['categoria'];
            $redes = $user_data['redes'];
            $contato = $user_data['contato'];
            $patrocinadores = $user_data['patrocinadores'];
        }
    } else {
        header('Location: sistema.php');
    }
} else {
    header('Location: sistema.php');
}
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

        <a href="sistAdm.php?page=consultaeventos.php" class="retbtn" title="Voltar"><i class='bx bxs-chevrons-left'></i></a>
        <div class="tablesuser">

            <form id="editForm" action="saveEditVcardEv.php" method="POST">
                <table class='user-table'>

                    <tr>
                        <td class='label special-label'>CHAVE</td>
                        <td class='value2'>
                            <label for='chave' class='chave-label'><?php echo $chave; ?></label>
                            <input type='hidden' name='chave' id='chave' value='' required>
                            <a class="whts" href="javascript:void(0);" onclick="copyToClipboard('<?php echo $chave; ?>')" title="Copiar">
                                <i class="bx bx-copy-alt"></i>
                            </a>
                            <a class="whtss" href="https://api.whatsapp.com/send?text=Aqui está a chave-convite para evento (<?php echo $titulo ?>): <?php echo $chave ?>" title="Compartilhar via Whatsapp">
                                <i class="bx bxl-whatsapp"></i>
                            </a>
        </div>
        </td>
        </tr>

        <tr>
            <td class='label special-label'>TITULO</td>
            <td class='value3'>
                <label for='titulo' class='titulo-label'><?php echo $titulo ?></label>
                <input type='text' name='titulo' id='titulo' value='' required>
    </div>
    </td>
    </tr>

    <tr>
        <td class='label special-label'>INFOS / LOCAL</td>
        <td class='value4'>
            <label for='apresentacao' class='apresentacao-label'>Informações e Local</label>
            <input type='text' name='apresentacao' id='apresentacao' value='' required>
            </div>
        </td>
    </tr>

    <tr>
        <td class='label special-label'>CATEGORIA</td>
        <td class='value8'>
            <label for='categoria' class='categoria-label'>Categoria do Evento</label>
            <input type='text' name='categoria' id='categoria' value='' required>
            </div>
        </td>
    </tr>

    <tr>
        <td class='label special-label'>REDES SOCIAIS</td>
        <td class='value9'>
            <label for='redes' class='redes-label'>Redes Sociais</label>
            <input type='text' name='redes' id='redes' value='' required>
            </div>
        </td>
    </tr>


    <tr>
        <td class='label special-label'>CONTATO</td>
        <td class='value10'>
            <label for='contato' class='contato-label'>Email / Telefone</label>
            <input type='text' name='contato' id='contato' value='' required>
            </div>
        </td>
    </tr>

    <tr>
        <td class='label special-label'>PATROCINADORES</td>
        <td class='value11'>
            <label for='patrocinadores' class='patrocinadores-label'>Patrocinadores</label>
            <input type='text' name='patrocinadores' id='patrocinadores' value='' required>
            </div>
        </td>
    </tr>

    </table>
    <div>
        <input type='hidden' name='id' value='<?php echo $id; ?>'>
        <input type='hidden' name='tipo' value='<?php echo $tipo; ?>'>
    </div>
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
            var inputCategoria = $('#categoria');
            var inputRedes = $('#redes');
            var inputContato = $('#contato');
            var inputPatrocinadores = $('#patrocinadores');
            var labelChave = $('.chave-label');
            var labelTitulo = $('.titulo-label');
            var labelApresentacao = $('.apresentacao-label');
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
            var chaveOriginal = '<?php echo $chave; ?>';
            var tituloOriginal = '<?php echo $titulo; ?>';
            var apresentacaoOriginal = '<?php echo $apresentacao; ?>';
            var categoriaOriginal = '<?php echo $categoria; ?>';
            var redesOriginal = '<?php echo $redes; ?>';
            var contatoOriginal = '<?php echo $contato; ?>';
            var patrocinadoresOriginal = '<?php echo $patrocinadores; ?>';


            // Defina o valor inicial do input e ajuste o estilo do rótulo
            inputChave.val(chaveOriginal).trigger('blur');
            inputTitulo.val(tituloOriginal).trigger('blur');
            inputApresentacao.val(apresentacaoOriginal).trigger('blur');
            inputCategoria.val(categoriaOriginal).trigger('blur');
            inputRedes.val(redesOriginal).trigger('blur');
            inputContato.val(contatoOriginal).trigger('blur');
            inputPatrocinadores.val(patrocinadoresOriginal).trigger('blur');

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
            inputCategoria.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputCategoria.val('');
                labelCategoria.css('top', '-8px');
                labelCategoria.css('font-size', '12px');
                labelCategoria.css('color', '#9a4dff');
                value8input.css('color', '#707070');
            });
            inputRedes.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputRedes.val('');
                labelRedes.css('top', '-8px');
                labelRedes.css('font-size', '12px');
                labelRedes.css('color', '#9a4dff');
                value9input.css('color', '#707070');
            });
            inputContato.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputContato.val('');
                labelContato.css('top', '-8px');
                labelContato.css('font-size', '12px');
                labelContato.css('color', '#9a4dff');
                value10input.css('color', '#707070');
            });
            inputPatrocinadores.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputPatrocinadores.val('');
                labelPatrocinadores.css('top', '-8px');
                labelPatrocinadores.css('font-size', '12px');
                labelPatrocinadores.css('color', '#9a4dff');
                value11input.css('color', '#707070');
            });

            // Adicione um ouvinte de evento para perder o foco no input
            inputChave.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputChave.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputChave.val(chaveOriginal);
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
                    inputTitulo.val(tituloOriginal);
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
                    inputApresentacao.val(apresentacaoOriginal);
                    labelApresentacao.css('top', '9px');
                    labelApresentacao.css('font-size', '16px');
                    labelApresentacao.css('color', 'rgb(165, 165, 165)');
                    value4input.css('color', '#fff');
                }
            });
            inputCategoria.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputCategoria.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputCategoria.val(categoriaOriginal);
                    labelCategoria.css('top', '9px');
                    labelCategoria.css('font-size', '16px');
                    labelCategoria.css('color', 'rgb(165, 165, 165)');
                    value8input.css('color', '#fff');
                }
            });
            inputRedes.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputRedes.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputRedes.val(redesOriginal);
                    labelRedes.css('top', '9px');
                    labelRedes.css('font-size', '16px');
                    labelRedes.css('color', 'rgb(165, 165, 165)');
                    value9input.css('color', '#fff');
                }
            });
            inputContato.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputContato.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputContato.val(contatoOriginal);
                    labelContato.css('top', '9px');
                    labelContato.css('font-size', '16px');
                    labelContato.css('color', 'rgb(165, 165, 165)');
                    value10input.css('color', '#fff');
                }
            });
            inputPatrocinadores.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputPatrocinadores.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputPatrocinadores.val(patrocinadoresOriginal);
                    labelPatrocinadores.css('top', '9px');
                    labelPatrocinadores.css('font-size', '16px');
                    labelPatrocinadores.css('color', 'rgb(165, 165, 165)');
                    value11input.css('color', '#fff');
                }
            });
        });

        // Define a variável com o valor desejado
        var perfilText = "EDIÇÃO VCARD";

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

        function copyToClipboard(text) {
            // Cria um elemento de input dinamicamente
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);

            // Seleciona o conteúdo do campo de input
            input.select();
            input.setSelectionRange(0, 99999); // Para dispositivos móveis

            // Copia o texto para a área de transferência
            document.execCommand('copy');

            // Remove o elemento de input
            document.body.removeChild(input);

            // Você pode adicionar aqui uma mensagem de sucesso, se desejar
            alert('Chave copiada para a área de transferência: ' + text);
        }
    </script>

</html>