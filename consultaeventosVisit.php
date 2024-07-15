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

    $sql = "SELECT * FROM eventos WHERE $column LIKE '%$data%' ORDER BY id_evento DESC";
} else {
    $sql = "SELECT * FROM eventos ORDER BY id_evento DESC";
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
                        <option value="id_evento">ID</option>
                        <option value="nome_evento">NOME</option>
                        <option value="nome_criador">CRIADOR</option>
                        <option value="chave">CHAVE</option>
                        <option value="endereco_evento">ENDEREÇO</option>
                        <option value="data_evento">DATA</option>
                    </select>
                    <button class="logout-button-1" onclick="searchData()" title="Pesquisar">
                        <i class='bx bx-search-alt'></i>
                    </button>
                    <div class="complemento">
                        <p>Busque um Evento!</p>
                    </div>
                    </di>
                </div>
                <div class="tabelausu">
                    <table class="table-cons">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOME EVENTO</th>
                                <th scope="col">NOME CRIADOR</th>
                                <th scope="col">ENDEREÇO</th>
                                <th scope="col">DATA</th>
                                <th scope="col" style="display: none;">CHAVE EVENTO</th>
                                <th scope="col">PARTICIPANTES</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($result)) {

                                // Step 1: Modify SQL query to include the count of participants
                                $chave = $user_data['chave'];
                                $countSql = "SELECT COUNT(*) AS participant_count FROM vcards WHERE chave = '$chave'";
                                $countResult = $conexao->query($countSql);
                                $countData = $countResult->fetch_assoc();
                                $participantCount = $countData['participant_count'];

                                // Step 2: Update the 'participantes' column in the 'eventos' table
                                $updateSql = "UPDATE eventos SET participantes = $participantCount WHERE chave = '$chave'";
                                $conexao->query($updateSql);

                                $nome_evento = $user_data['nome_evento'];
                                $id_showvcard_sql = "SELECT id FROM vcards WHERE titulo = '$nome_evento'";
                                $id_showvcard_result = $conexao->query($id_showvcard_sql);

                                if ($id_showvcard_result) {
                                    $id_showvcard_data = $id_showvcard_result->fetch_assoc();

                                    // Verifica se $id_showvcard_data não é null e se a chave 'id' está definida
                                    if ($id_showvcard_data !== null && isset($id_showvcard_data['id'])) {
                                        $id_showvcard = $id_showvcard_data['id'];
                                    } else {
                                        // Trate o caso em que 'id' não está definido ou $id_showvcard_data é null
                                        $id_showvcard = 0; // ou qualquer valor padrão
                                    }
                                } else {
                                    // Trate o caso em que a consulta falhou
                                    $id_showvcard = 0; // ou qualquer valor padrão
                                }
                                echo "<tr>";
                                echo "<td class='table-cons2'>" . $user_data['id_evento'] . "</td>";
                                echo "<td class='table-cons2'>" . $user_data['nome_evento'] . "</td>";
                                echo "<td class='table-cons2'>" . $user_data['nome_criador'] . "</td>";
                                echo "<td class='table-cons2'>" . $user_data['endereco_evento'] . "</td>";
                                echo "<td class='table-cons2'>" . date('d-m-Y', strtotime($user_data["data_evento"])) . "</td>";
                                echo "<td class='table-cons2' style='display: none;'>" . $user_data['chave'] . "</td>";
                                echo "<td class='table-cons2'>" . $participantCount . "</td>";
                                echo "<td>
                            <a class='actbtn' href='sistVisit.php?page=showvcardEvVisit.php?id=$id_showvcard' title='Visualizar'>
                            <i class='bx bx-show'></i>
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
            var perfilText = "Busca Eventos";

            // Envia a variável para a página pai (sistVisit.php)
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
                var search = document.getElementById('pesquisar');
                var searchTerm = encodeURIComponent(search.value);
                var selectedColumn = document.getElementById('selectColumn').value;

                // Verifica se a coluna selecionada é 'data_evento'
                if (selectedColumn === 'data_evento') {
                    // Formata a data no formato 'yyyy-mm-dd'
                    var formattedDate = formatDate(searchTerm);
                    $('#content-placeholder').load('consultaeventosVisit.php?search=' + formattedDate + '&column=' + selectedColumn);
                } else {
                    $('#content-placeholder').load('consultaeventosVisit.php?search=' + searchTerm + '&column=' + selectedColumn);
                }
            }

            function formatDate(inputDate) {
                // Converte a data de 'dd-mm-yyyy' para 'yyyy-mm-dd'
                var parts = inputDate.split("-");
                var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                return formattedDate;
            }
        </script>


</body>

</html>