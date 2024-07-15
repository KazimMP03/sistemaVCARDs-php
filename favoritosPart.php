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

$ordenacao = 'id_favoritos DESC'; // Valor padrão

if (isset($_GET['ordena'])) {
    $sort = $_GET['ordena'];

    if ($sort == 'titulo') {
        $ordenacao = 'titulo_vcard ASC'; // Ordenar por título em ordem ascendente

    } elseif ($sort == 'data') {
        $ordenacao = 'data_vcard ASC'; // Ordenar por data_vcard em ordem descendente

    }
}

if (!empty($_GET['buscafav'])) {
    $buscafav = trim(mysqli_real_escape_string($conexao, $_GET['buscafav']));

    $sql = "SELECT * FROM vcards_favoritos WHERE titulo_vcard LIKE '%$buscafav%' AND id_usuario = '$id' ORDER BY $ordenacao";
} else {
    $sql = "SELECT * FROM vcards_favoritos WHERE id_usuario = '$id' ORDER BY $ordenacao";
}
$result = $conexao->query($sql);

if (!$result) {
    die('Erro na consulta: ' . $conexao->error);
}

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
    <div class="fundofav">

        <div class="container">
            <div class="flip-cardorde" title="' . $vcard_data['titulo'] . '">
                <div class="flip-card-innerorde">
                    <div class="flip-card-front">
                        <div class="buscafavorde" style="cursor: pointer;" id="ordenarPorTitulo">
                            <p>Ordenar por Título</p>
                        </div>
                        <div class="buscafavorde" style="cursor: pointer;" id="ordenarPorData">
                            <p>Ordenar por Data</p>
                        </div>
                        <div class="buscafavpesq">
                            <form id="searchForm" method="GET" action="favoritos.php">
                                <input type="text" placeholder="Buscar por Título" name="buscafav" id="buscafav" class="pesquisafav">
                                <br>
                                <button type="submit" class="logout-button-mini" style="cursor: pointer;" title="Pesquisar">
                                    <i class='bx bx-search-alt'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        while ($user_data = mysqli_fetch_assoc($result)) {
            $id_vcard = $user_data['id_vcard'];

            // Consulta para obter informações da tabela "vcards"
            $vcards_sql = "SELECT titulo, apresentacao, data_pub, categoria, redes, contato, patrocinadores, data_vcard, imagem FROM vcards WHERE id = '$id_vcard'";
            $vcards_result = $conexao->query($vcards_sql);


            if (!$vcards_result) {
                die('Erro na consulta da tabela vcards: ' . $conexao->error);
            }

            // Extrai as informações da tabela "vcards"
            $vcard_data = mysqli_fetch_assoc($vcards_result);

            // Verifica se a coluna "imagem" está vazia e define o valor de $imagemvcard
            $imagemvcard = empty($vcard_data['imagem']) ? 'imgs/imagemvcard1.png' : $vcard_data['imagem'];

            // Substitui os valores no seu código
            echo '<div class="container" onclick="redirectVcardBig(' . $id_vcard . ')">
            <div class="flip-card" style="cursor: pointer;" title="' . $vcard_data['titulo'] . '">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="whitebg">
                            <div class="titulovcard">
                                <p>' . $vcard_data['titulo'] . '</p>
                            </div>
                        </div>
                        <div class="card-header">
                            <img src="' . $imagemvcard . '" alt="Avatar" class="card-img">
                        </div>
                        <div class="descricaovcard">
                            <p>' . $vcard_data['apresentacao'] . '</p>
                        </div>
                        <div class="datavcard">
                            <p>' . date('d-m-Y', strtotime($vcard_data['data_vcard'])) . '</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        }
        ?>
    </div>
    <script>
        // Define a variável com o valor desejado
        var perfilText = "VCARDS FAVORITOS";

        // Envia a variável para a página pai (sistPart.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        function redirectVcardBig(id_vcard) {
            window.location.href = 'sistPart.php?page=vcardbigPart.php?id_vcard=' + id_vcard;
        }

        document.getElementById('ordenarPorTitulo').addEventListener('click', function() {
            window.location.href = 'sistPart.php?page=favoritosPart.php?ordena=titulo';
        });

        document.getElementById('ordenarPorData').addEventListener('click', function() {
            window.location.href = 'sistPart.php?page=favoritosPart.php?ordena=data';
        });

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var buscafav = document.getElementById('buscafav').value;

            // Substitui os espaços por underscores
            buscafav = buscafav.replace(/ /g, '_');

            window.location.href = 'sistPart.php?page=favoritosPart.php?buscafav=' + encodeURIComponent(buscafav);
        });
    </script>


</body>

</html>