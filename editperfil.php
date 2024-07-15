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
    $sqlSelect = "SELECT * FROM usuarios WHERE id='$id'";
    $result = $conexao->query($sqlSelect);
    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            $nome = $user_data['nome'];
            $sexo = $user_data['sexo'];
            $tipo = $user_data['tipo'];
            $data = $user_data['datanasc'];
            $cidade = $user_data['cidade'];
            $email = $user_data['email'];
            $senha = $user_data['senha'];
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
        <a href="#" class="retbtn" onclick="idTipo()"><i class='bx bxs-chevrons-left' title="Voltar"></i></a>
        <div class="tablesuser">

            <form id="editForm" action="saveEditUser.php" method="POST">
                <table class='user-table'>
                    <tr>
                        <td class='label special-label'>NOME</td>
                        <td class='value5'>

                            <label for='nome' class='nome-label'><?php echo $nome; ?></label>
                            <input type='text' name='nome' id='nome' value='<?php echo $nome; ?>' required>
        </div>
        </td>
        </tr>

        <tr>
            <td class='label special-label'>SEXO</td>
            <td class='value6'>
                <input type='radio' id='feminino' name='genero' value='Feminino' <?php echo ($sexo == 'Feminino') ? 'checked' : ''; ?> required>
                <label for='feminino'>Feminino</label>
                <br>
                <input type='radio' id='masculino' name='genero' value='Masculino' <?php echo ($sexo == 'Masculino') ? 'checked' : ''; ?> required>
                <label for='masculino'>Masculino</label>
                <br>
                <input type='radio' id='outro' name='genero' value='Outro' <?php echo ($sexo == 'Outro') ? 'checked' : ''; ?> required>
                <label for='outro'>Outro</label>
            </td>
        </tr>

        <tr>
            <td class='label special-label'>NASCIMENTO</td>
            <td class='value7'>
                <input type='date' name='data_nascimento' id='data_nascimento' value='<?php echo $data; ?>' required>
            </td>
        </tr>

        <tr>
            <td class='label special-label'>CIDADE</td>
            <td class='value2'>
                <label for='cidade' class='cidade-label'><?php echo $cidade; ?></label>
                <input type='text' name='cidade' id='cidade' value='<?php echo $cidade; ?>' required>
            </td>
        </tr>

        <tr>
            <td class='label special-label'>EMAIL</td>
            <td class='value3'>
                <label for='email' class='email-label'><?php echo $email; ?></label>
                <input type='text' name='email' id='email' value='<?php echo $email; ?>' required>
            </td>
        </tr>

        <tr>
            <td class='label special-label'>SENHA</td>
            <td class='value4'>
                <label for='senha' class='senha-label'><?php echo $senha; ?></label>
                <input type='text' name='senha' id='senha' value='<?php echo $senha; ?>' required>
            </td>
        </tr>

        </table>
        <div>
            <input type='hidden' name='id' value='<?php echo $id; ?>'>
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
            var cidadeOriginal = '<?php echo $cidade; ?>';
            var emailOriginal = '<?php echo $email; ?>';
            var senhaOriginal = '<?php echo $senha; ?>';
            var nomeOriginal = '<?php echo $nome; ?>';

            // Defina o valor inicial do input e ajuste o estilo do rótulo
            inputCidade.val(cidadeOriginal).trigger('blur');
            inputEmail.val(emailOriginal).trigger('blur');
            inputSenha.val(senhaOriginal).trigger('blur');
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
                    inputCidade.val(cidadeOriginal);
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
                    inputEmail.val(emailOriginal);
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
                    inputSenha.val(senhaOriginal);
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
                    inputNome.val(nomeOriginal);
                    labelNome.css('top', '9px');
                    labelNome.css('font-size', '16px');
                    labelNome.css('color', 'rgb(165, 165, 165)');
                    value5input.css('color', '#fff');
                }
            });
        });

        // Define a variável com o valor desejado
        var perfilText = "EDITAR PERFIL";

        // Envia a variável para a página pai (sistAdm.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        function validarEmail(email) {
            // Expressão regular para validar o formato do e-mail
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        document.getElementById('submitFormLink').addEventListener('click', function(event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Verifica o formato do e-mail
            var email = $('#email').val();
            if (!validarEmail(email)) {
                alert('Formato de e-mail inválido. Tente o formato "aa@bb.cc"');
                return;
            }

            // Submete o formulário se o e-mail estiver no formato correto
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
                    echo 'window.location.href = "sistOrg.php?page=perfilOrg.php";';
                    break;
                case 'Participante':
                    echo 'window.location.href = "sistPart.php?page=perfilPart.php";';
                    break;
                case 'Visitante':
                    echo 'window.location.href = "sistVisit.php?page=perfilVisit.php";';
                    break;
                default:
                    // Redirecionamento padrão, caso o tipo não seja reconhecido
                    echo 'window.location.href = "sistPart.php";';
            }
            ?>
        }
    </script>

</html>