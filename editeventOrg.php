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

if (!empty($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];
    $sqlSelect = "SELECT * FROM eventos WHERE id_evento='$id_evento'";
    $result = $conexao->query($sqlSelect);
    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            $nome_evento = $user_data['nome_evento'];
            $data_evento = $user_data['data_evento'];
            $local_evento = $user_data['endereco_evento'];
        }
    } else {
        header('Location: sistAnon.php');
    }
} else {
    header('Location: sistOrg.php');
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
        <a href="sistOrg.php?page=consultaeventosOrg.php" class="retbtn" title="Voltar"><i class='bx bxs-chevrons-left'></i></a>
        <div class="tablesuser">

            <form id="editForm" action="saveEditEventOrg.php" method="POST">
                <table class='user-table'>
                    <tr>
                        <td class='label special-label'>NOME</td>
                        <td class='value5'>
                            <label for='nome_evento' class='nome-label'><?php echo $nome_evento; ?></label>
                            <input type='text' name='nome_evento' id='nome_evento' value='<?php echo $nome_evento; ?>' required>
        </div>
        </td>
        </tr>

        <tr>
            <td class='label special-label'>ENDEREÇO</td>
            <td class='value2'>
                <label for='local' class='cidade-label'><?php echo $local_evento; ?></label>
                <input type='text' name='local' id='local' value='<?php echo $local_evento; ?>' required>
            </td>
        </tr>

        <tr>
            <td class='label special-label'>DATA</td>
            <td class='value7'>
                <input type='date' name='data_evento' id='data_evento' value='<?php echo $data_evento; ?>' required>
            </td>
        </tr>

        </table>
        <div>
            <input type='hidden' name='id_evento' value='<?php echo $id_evento; ?>'>
            <input type='hidden' name='tipo' value='<?php echo $tipo; ?>'>
        </div>
        <button type="submit" name="update" id="updateButton" style="display: none;"></button>

        </form>
    </div>
    <div>
        <a href="#" class="editbtn" id="submitFormLink" title="Salvar"><i class='bx bx-check-circle'></i></a>
    </div>

    </div>

    <script>
        $(document).ready(function() {
            var inputCidade = $('#local');
            var inputNome = $('#nome_evento');
            var labelNome = $('.nome-label');
            var labelCidade = $('.cidade-label');
            var value2input = $('.value2 input');
            var value5input = $('.value5 input');
            var cidadeOriginal = '<?php echo $local_evento; ?>';
            var nomeOriginal = '<?php echo $nome_evento; ?>';

            // Defina o valor inicial do input e ajuste o estilo do rótulo
            inputCidade.val(cidadeOriginal).trigger('blur');
            inputNome.val(nomeOriginal).trigger('blur');

            // Adicione um ouvinte de evento para o foco no input
            inputCidade.focus(function() {
                // Quando o input é focado, ajuste o estilo do rótulo e remova o valor
                inputCidade.val('');
                labelCidade.css('top', '-8px');
                labelCidade.css('font-size', '12px');
                labelCidade.css('color', '#9a4dff');
                value2input.css('color', '#707070');
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
                    inputCidade.val(cidadeOriginal);
                    labelCidade.css('top', '9px');
                    labelCidade.css('font-size', '16px');
                    labelCidade.css('color', 'rgb(165, 165, 165)');
                    value2input.css('color', '#fff');
                }
            });
            inputNome.blur(function() {
                // Verifique se o input está vazio ao perder o foco
                if (inputNome.val() === '') {
                    // Se estiver vazio, retorne o rótulo à posição original e restaure o valor
                    inputNome.val(nomeOriginal);
                    labelNome.css('top', '9px');
                    labelNome.css('font-size', '16px');
                    labelNome.css('color', 'rgb(165, 165, 165)');
                    value5input.css('color', '#fff');
                }
            });
        });

        // Define a variável com o valor desejado
        var perfilText = "EDITAR EVENTO";

        // Envia a variável para a página pai (sistOrg.php)
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