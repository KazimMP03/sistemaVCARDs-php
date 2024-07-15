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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="fundo">

        <!-- Botão Voltar -->
        <a href="sistOrg.php?page=consultausuariosOrg.php" class="retbtn" title="Voltar"><i class='bx bxs-chevrons-left'></i></a>

        <!-- DIV do formulário -->
        <div class="tablesuser">
            <form id="editForm" action="testCadastroOrg.php" method="POST">
                <table class='user-table'>

                    <tr>
                        <td class='label special-label'>NOME</td>
                        <td class='value5'>
                            <label for='nome' class='nome-label'>Nome</label>
                            <input type='text' name='nome' id='nome' required>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>SEXO</td>
                        <td class='value6'>
                            <input type='radio' id='feminino' name='genero' value='Feminino' required>
                            <label for='feminino'>Feminino</label>
                            <br>
                            <input type='radio' id='masculino' name='genero' value='Masculino' required>
                            <label for='masculino'>Masculino</label>
                            <br>
                            <input type='radio' id='outro' name='genero' value='Outro' required>
                            <label for='outro'>Outro</label>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>NASCIMENTO</td>
                        <td class='value7'>
                            <input type='date' name='data_nascimento' id='data_nascimento' required>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>TIPO DE USUÁRIO</td>
                        <td class='value7'>
                            <select class="tipo-input" id="tipo" name="tipo">
                                <option value="Participante">Participante</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>CIDADE</td>
                        <td class='value2'>
                            <label for='cidade' class='cidade-label'>Cidade</label>
                            <input type='text' name='cidade' id='cidade' required>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>EMAIL</td>
                        <td class='value3'>
                            <label for='email' class='email-label'>Email</label>
                            <input type='text' name='email' id='email' required>
                        </td>
                    </tr>

                    <tr>
                        <td class='label special-label'>SENHA</td>
                        <td class='value4'>
                            <label for='senha' class='senha-label'>Senha</label>
                            <input type='text' name='senha' id='senha' required>
                        </td>
                    </tr>

                </table>
                <!-- Botão invisível de submit -->
                <button type="submit" name="submit" id="updateButton" style="display: none;"></button>
            </form>
        </div>

        <!-- Botão que o usuário clica para salvar -->
        <div>
            <a href="#" class="editbtn" id="submitFormLink" title="Salvar"><i class='bx bx-check-circle'></i></a>
        </div>
    </div>

    <script>
        // Estilização dos campos do formulátio
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

            // Quando o usuário clica no campo
            inputCidade.focus(function() {
                inputCidade.val('');
                labelCidade.css('top', '-8px');
                labelCidade.css('font-size', '12px');
                labelCidade.css('color', '#9a4dff');
                value2input.css('color', '#707070');
            });
            inputEmail.focus(function() {
                inputEmail.val('');
                labelEmail.css('top', '-8px');
                labelEmail.css('font-size', '12px');
                labelEmail.css('color', '#9a4dff');
                value3input.css('color', '#707070');
            });
            inputSenha.focus(function() {
                inputSenha.val('');
                labelSenha.css('top', '-8px');
                labelSenha.css('font-size', '12px');
                labelSenha.css('color', '#9a4dff');
                value4input.css('color', '#707070');
            });
            inputNome.focus(function() {
                inputNome.val('');
                labelNome.css('top', '-8px');
                labelNome.css('font-size', '12px');
                labelNome.css('color', '#9a4dff');
                value5input.css('color', '#707070');
            });

            // Quando o usuário clica fora do campo
            inputCidade.blur(function() {
                if (inputCidade.val() === '') {
                    inputCidade.val('');
                    labelCidade.css('top', '9px');
                    labelCidade.css('font-size', '16px');
                    labelCidade.css('color', 'rgb(165, 165, 165)');
                    value2input.css('color', '#fff');
                }
            });
            inputEmail.blur(function() {
                if (inputEmail.val() === '') {
                    inputEmail.val('');
                    labelEmail.css('top', '9px');
                    labelEmail.css('font-size', '16px');
                    labelEmail.css('color', 'rgb(165, 165, 165)');
                    value3input.css('color', '#fff');
                }
            });
            inputSenha.blur(function() {
                if (inputSenha.val() === '') {
                    inputSenha.val('');
                    labelSenha.css('top', '9px');
                    labelSenha.css('font-size', '16px');
                    labelSenha.css('color', 'rgb(165, 165, 165)');
                    value4input.css('color', '#fff');
                }
            });
            inputNome.blur(function() {
                if (inputNome.val() === '') {
                    inputNome.val('');
                    labelNome.css('top', '9px');
                    labelNome.css('font-size', '16px');
                    labelNome.css('color', 'rgb(165, 165, 165)');
                    value5input.css('color', '#fff');
                }
            });
        });

        // Nome da página na barra denavegação superior
        var perfilText = "Adicionar Usuário";

        // Envia a variável para a página pai (sistOrg.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        // Valida o formato do e-mail
        function validarEmail(email) {
            // Expressão regular para validar o formato do e-mail
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
        // Envia o formulário
        document.getElementById('submitFormLink').addEventListener('click', function(event) {
            event.preventDefault();

            // Verifica o formato do e-mail enviado
            var email = $('#email').val();
            if (!validarEmail(email)) {
                alert('Formato de e-mail inválido. Tente o formato "aa@bb.cc"');
                return;
            }

            // Submete o formulário se o e-mail estiver no formato correto
            document.getElementById('updateButton').click();
        });
    </script>

</body>

</html>