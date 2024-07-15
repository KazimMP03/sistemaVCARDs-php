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

if (!empty($_GET['search'])) {
    $data = mysqli_real_escape_string($conexao, $_GET['search']);
    $column = mysqli_real_escape_string($conexao, $_GET['column']);

    $sql = "SELECT u.* FROM usuarios u
            JOIN vcards v ON u.id = v.id_proprietario
            JOIN eventos e ON v.chave = e.chave
            WHERE e.id_criador = $id
            AND u.$column LIKE '%$data%'
            ORDER BY u.id DESC";
} else {
    $sql = "SELECT u.* FROM usuarios u
            JOIN vcards v ON u.id = v.id_proprietario
            JOIN eventos e ON v.chave = e.chave
            WHERE e.id_criador = $id
            ORDER BY u.id DESC";
}
$result = $conexao->query($sql);

?>
<!-- Restante do HTML permanece inalterado -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <div class="fundo2">
        <div class="tablesuser2">
            <div>
                <div class="search-container">
                    <input type="search" placeholder="Pesquisar" id="pesquisar" class="searchusu">
                    <div class="em">
                        <p>em</p>
                    </div>
                    <select class="selectbox" id="selectColumn">
                        <option value="id">ID</option>
                        <option value="nome">NOME</option>
                        <option value="tipo">TIPO</option>
                        <option value="email">EMAIL</option>
                    </select>
                    <button class="logout-button-1" onclick="searchData()" title="Pesquisar">
                        <i class='bx bx-search-alt'></i>
                    </button>
                    <div class="complemento">
                        <p>Busque um Usuário!</p>
                    </div>
                    <div class="contanon">
                        <div class="anuncioanon">
                            <p>Visitas Anônimas:</p>
                        </div>
                        <div class="numanon">
                            <?php
                            // Consulta para recuperar o valor da coluna "contador" da tabela "anonimos" onde o valor da coluna "id" é igual a 1
                            $sql_anonimos = "SELECT contador FROM anonimos WHERE id = 1";
                            $result_anonimos = $conexao->query($sql_anonimos);

                            // Verifica se a consulta foi bem-sucedida e se há pelo menos uma linha de resultado
                            if ($result_anonimos && $result_anonimos->num_rows > 0) {
                                // Obtém os dados da linha de resultado
                                $anonimos_data = $result_anonimos->fetch_assoc();
                                // Obtém o valor da coluna "contador"
                                $contador_anonimos = $anonimos_data['contador'];
                            } else {
                                // Em caso de erro ou se não houver resultados, defina um valor padrão
                                $contador_anonimos = "N/A";
                            }

                            // Exibe o valor do contador_anonimos
                            echo "<p>$contador_anonimos</p>";
                            ?>
                        </div>
                    </div>
                    <a class='addmembbtn' href="#" onclick="addMember()" title="Adicionar Usuário">
                        <i class='bx bx-user-plus'></i>
                    </a>
                </div>
            </div>
            <div class="tabelausu">
                <table class="table-cons">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">SEXO</th>
                            <th scope="col">NASCIMENTO</th>
                            <th scope="col">CIDADE</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">SENHA</th>
                            <th scope="col">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($user_data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='table-cons2'>" . $user_data['id'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['nome'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['tipo'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['sexo'] . "</td>";
                            echo "<td class='table-cons2'>" . date('d-m-Y', strtotime($user_data["datanasc"])) . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['cidade'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['email'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['senha'] . "</td>";
                            echo "<td>
                            <a class='actbtn' href='sistOrg.php?page=editorg.php?id=$user_data[id]' title='Editar'>
                            <i class='bx bx-edit'></i>
                                </a> 
                                <a class='actbtn' href='deleteuser.php?id=$user_data[id]' title='Deletar'>
                                <i class='bx bx-trash'></i>
                            </a>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // Define a variável com o valor desejado
        var perfilText = "Busca Usuários";

        // Envia a variável para a página pai (sistOrg.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        var search = document.getElementById('pesquisar');

        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        });

        function searchData() {
            var searchTerm = encodeURIComponent(search.value);
            var selectedColumn = document.getElementById('selectColumn').value;
            $('#content-placeholder').load('consultausuariosOrg.php?search=' + searchTerm + '&column=' + selectedColumn);
        }

        function addMember() {
            $('#content-placeholder').load('sistOrg.php?page=cadastroorg.php');
        }
    </script>


</body>

</html>