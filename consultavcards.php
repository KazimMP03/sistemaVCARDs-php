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

    $sql = "SELECT * FROM vcards WHERE $column LIKE '%$data%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM vcards ORDER BY id DESC";
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
                        <option value="chave">CHAVE</option>
                        <option value="titulo">TITULO</option>
                        <option value="categoria">CATEGORIA</option>
                        <option value="nome_proprietario">PROPRIETARIO</option>
                        <option value="data_vcard">DATA</option>
                    </select>
                    <button class="logout-button-1" onclick="searchData()" title="Pesquisar">
                        <i class='bx bx-search-alt'></i>
                    </button>
                    <div class="complemento">
                        <p>Busque um Vcard!</p>
                    </div>
                    <a class='addmembbtn' href="#" onclick="addVcard()" title="Criar Vcard">
                        <i class='bx bx-layer-plus'></i>
                    </a>
                </div>
            </div>
            <div class="tabelausu">
                <table class="table-cons">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">CHAVE EVENTO</th>
                            <th scope="col">TITULO</th>
                            <th scope="col">CATEGORIA</th>
                            <th scope="col">DATA</th>
                            <th scope="col">PROPRIETARIO</th>
                            <th scope="col">VISUAL</th>
                            <th scope="col">FAV</th>
                            <th scope="col">LIKES</th>
                            <th scope="col">SHARES</th>
                            <th scope="col">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($user_data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='table-cons2'>" . $user_data['id'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['chave'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['titulo'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['categoria'] . "</td>";
                            echo "<td class='table-cons2'>" . date('d-m-Y', strtotime($user_data["data_vcard"])) . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['nome_proprietario'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['visualizacoes'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['favoritado'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['likes'] . "</td>";
                            echo "<td class='table-cons2'>" . $user_data['compartilhamentos'] . "</td>";
                            echo "<td>
                            <a class='actbtn' href='sistAdm.php?page=editvcard.php?id=$user_data[id]' title='Editar'>
                            <i class='bx bx-edit'></i>
                                </a> 
                                <a class='actbtn' href='deletevcard.php?id=$user_data[id]' title='Deletar'>
                                <i class='bx bx-trash'></i>
                            </a>
                            <a class='actbtn' href='sistAdm.php?page=showvcard.php?id=$user_data[id]' title='Visualizar'>
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
        var perfilText = "CONSULTA VCARDS";

        // Envia a variável para a página pai (sistAdm.php)
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
            if (selectedColumn === 'data_vcard') {
                // Formata a data no formato 'yyyy-mm-dd'
                var formattedDate = formatDate(searchTerm);
                $('#content-placeholder').load('consultavcards.php?search=' + formattedDate + '&column=' + selectedColumn);
            } else {
                $('#content-placeholder').load('consultavcards.php?search=' + searchTerm + '&column=' + selectedColumn);
            }
        }

        function formatDate(inputDate) {
            // Converte a data de 'dd-mm-yyyy' para 'yyyy-mm-dd'
            var parts = inputDate.split("-");
            var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
            return formattedDate;
        }

        function addVcard() {
            $('#content-placeholder').load('sistAdm.php?page=cadastrovcard.php');
        }
    </script>

</body>

</html>