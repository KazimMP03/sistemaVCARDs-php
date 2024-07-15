<?php
session_start();
include_once('config.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}
$logado = $_SESSION['email'];
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$tipo = $_SESSION['tipo'];
$id = $_SESSION['id'];
$foto = $_SESSION['foto'];

if ($tipo !== 'Participante') {
    header('Location: sair.php');
    exit;
}

if (empty($_SESSION['foto'])) {
    $fotoUsuario = "imgs/perfilvazio.png"; // Caminho da imagem padrão
} else {
    $fotoUsuario = isset($_SESSION['foto']) ? $_SESSION['foto'] : '';
}

if (isset($_GET['page'])) {
    $pageToLoad = $_GET['page'];
} else {
    $pageToLoad = 'perfilPart.php';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo']) && isset($_POST['id_vcard'])) {
    $id_vcard = $_POST['id_vcard'];
    $arquivo = $_FILES['arquivo'];


    if ($arquivo['error']) {
        echo "<script>alert('Erro ao carregar a foto!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }
    if ($arquivo['size'] > 2100000) {
        echo "<script>alert('A foto deve ter no máximo 2mb de tamanho!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }

    $pasta = "fotos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if ($extensao != "jpg" && $extensao != 'png') {
        echo "<script>alert('O arquivo da foto deve possuir a extensãp .png ou .jpg!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }

    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $pasta . $novoNomeDoArquivo . "." . $extensao);

    if ($deu_certo) {
        // Antes de atualizar o banco de dados, exclua o arquivo antigo se existir
        $sqlFotoAntiga = "SELECT imagem FROM vcards WHERE id=$id_vcard";
        $resultFotoAntiga = mysqli_query($conexao, $sqlFotoAntiga);

        if ($resultFotoAntiga) {
            $rowFotoAntiga = mysqli_fetch_assoc($resultFotoAntiga);
            $fotoAntiga = $rowFotoAntiga['imagem'];

            // Certifique-se de que o arquivo antigo existe antes de excluí-lo
            if (file_exists($fotoAntiga)) {
                unlink($fotoAntiga); // Excluir o arquivo antigo
            }
        }
        // Antes de atualizar o banco de dados, exclua o arquivo antigo se existir

        $sqlUpdate = "UPDATE vcards SET imagem='$path' WHERE id=$id_vcard";
        $result = mysqli_query($conexao, $sqlUpdate);

        if ($result) {

            echo "<script>alert('Foto atualizada com sucesso!'); window.location.href='sistPart.php?page=editvcard.php?id=$id_vcard';</script>";
            exit;
        } else {
            echo "<script>alert('Erro ao carregar a foto! Tente novamente mais tarde.'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        }
    } else {
        echo "<script>alert('Erro ao carregar a foto! Tente novamente mais tarde.'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $arquivo = $_FILES['foto'];

    if ($arquivo['error']) {
        echo "<script>alert('Erro ao carregar a foto!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }
    if ($arquivo['size'] > 2100000) {
        echo "<script>alert('A foto deve ter no máximo 2mb de tamanho!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }
    // Obtém as dimensões da imagem
    $dimensoes = getimagesize($arquivo['tmp_name']);
    $largura = $dimensoes[0];
    $altura = $dimensoes[1];

    // Verifica se a imagem é um quadrado
    if ($largura !== $altura) {
        echo "<script>alert('A imagem deve ser um quadrado perfeito largura = altura!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }
    $pasta = "fotos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if ($extensao != "jpg" && $extensao != 'png') {
        echo "<script>alert('O arquivo da foto deve possuir a extensãp .png ou .jpg!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        exit;
    }

    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $pasta . $novoNomeDoArquivo . "." . $extensao);

    if ($deu_certo) {
        // Antes de atualizar o banco de dados, exclua o arquivo antigo se existir
        $sqlFotoAntiga = "SELECT foto FROM usuarios WHERE id=$id";
        $resultFotoAntiga = mysqli_query($conexao, $sqlFotoAntiga);

        if ($resultFotoAntiga) {
            $rowFotoAntiga = mysqli_fetch_assoc($resultFotoAntiga);
            $fotoAntiga = $rowFotoAntiga['foto'];

            // Certifique-se de que o arquivo antigo existe antes de excluí-lo
            if (file_exists($fotoAntiga)) {
                unlink($fotoAntiga); // Excluir o arquivo antigo
            }
        }

        $sqlUpdate = "UPDATE usuarios SET foto='$path' WHERE id=$id";
        $result = mysqli_query($conexao, $sqlUpdate);

        if ($result) {
            $_SESSION['foto'] = $path;
            echo "<script>alert('Foto atualizada com sucesso!'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
            exit;
        } else {
            echo "<script>alert('Erro ao carregar a foto! Tente novamente mais tarde.'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
        }
    } else {
        echo "<script>alert('Erro ao carregar a foto! Tente novamente mais tarde.'); window.location.href='sistPart.php?page=perfilPart.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sistema.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>EasyVCARDS - Participante</title>
</head>

<body>

    <nav class="sidebar">

        <header>
            <div class="image-text">
                <span class="image">
                    <img src="imgs/logocut.png" alt="">
                </span>
                <div class="text logo-text">
                    <span class="profession">
                        <span class="easy">Easy</span>
                        <span class="vcards">VCARDS</span>
                    </span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>

        </header>

        <div class="custom-image-container">
            <img src="<?php echo $fotoUsuario; ?>" class="custom-image">
            <div class="custom-text">
                <p class="custom-text-line"><?php echo "$nome" ?></p>
                <p class="custom-text-line2"><?php echo strtoupper("$tipo") ?></p>
            </div>
        </div>
        </img>


        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="#" data-page="perfilPart.php">
                            <i class='bx bx-user-circle icon' title="Perfil"></i>
                            <span class="text nav-text">Perfil</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#" data-page="consultaeventosPart.php">
                            <i class='bx bx-store-alt icon' title="Eventos"></i>
                            <span class="text nav-text">Eventos</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#" data-page="consultavcardsPart.php">
                            <i class='bx bx-news icon' title="Vcards"></i>
                            <span class="text nav-text">Vcards</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#" data-page="favoritosPart.php">
                            <i class='bx bx-star icon' title="Favoritos"></i>
                            <span class="text nav-text">Favoritos</span>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="bottom-content">

                <li class="nav-link">
                    <a href="sair.php">
                        <i class='bx bx-log-out icon logout-icon' title="Logout"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

            </div>
        </div>
    </nav>

    <section class="home" id="home-section">

        <div class="navbar">
            <div class="navbar-content">
                <span class="navbar-text-left" id="perfilTextPlaceholder"></span>
            </div>
            <div class="navbar-content">
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sistPart.php?page=perfilPart.php'" title="Perfil">
                    <i class='bx bx-user-circle'></i>
                </button>
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sistPart.php?page=consultaeventosPart.php'" title="Eventos">
                    <i class='bx bx-store-alt'></i>
                </button>
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sistPart.php?page=consultavcardsPart.php'" title="Vcards">
                    <i class='bx bx-news'></i>
                </button>
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sistPart.php?page=favoritosPart.php'" title="Favoritos">
                    <i class='bx bx-star'></i>
                </button>
                <button class="logout-button3" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sair.php'" title="Logout">
                    <i class='bx bx-log-out'></i>
                </button>

                <button class="logout-button2" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="toggleDropdown()">
                    <i class='bx bx-menu'></i>

                    <div class="dropdown" id="dropdown-menu">
                        <a href="sistPart.php?page=perfilPart.php" title="Perfil"><i class='bx bx-user-circle' title="Perfil"></i></a>
                        <a href="sistPart.php?page=consultaeventosPart.php" title="Eventos"><i class='bx bx-store-alt' title="Eventos"></i></a>
                        <a href="sistPart.php?page=consultavcardsPart.php" title="Vcards"><i class='bx bx-news' title="Vcards"></i></a>
                        <a href="sistPart.php?page=favoritosPart.php" title="Favoritos"><i class='bx bx-star' title="Favoritos"></i></a>
                        <a href="sair.php" title="Logout"><i class='bx bx-log-out' title="Logout"></i></a>
                    </div>
                </button>
            </div>
        </div>

        <div class="text" id="content-placeholder">
        </div>

    </section>

    <script src="js/sistema.js"></script>

    <script>
        $(document).ready(function() {
            $('.menu-links a').click(function(e) {
                e.preventDefault();

                var pageToLoad = $(this).data('page');
                $('#content-placeholder').load(pageToLoad);
            });

            $('#content-placeholder').load('<?php echo $pageToLoad; ?>');


        });

        function updateNavbarText(text) {
            $('.navbar-text-left').text(text);
        }

        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle('open');
        }

        // Fechar o menu suspenso ao clicar fora dele
        document.addEventListener('click', function(event) {
            const dropdownMenu = document.getElementById('dropdown-menu');
            if (event.target.closest('.logout-button2') === null && event.target.closest('#dropdown-menu') === null) {
                dropdownMenu.classList.remove('open');
            }
        });
    </script>

</body>

</html>