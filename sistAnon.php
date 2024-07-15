<?php

if (isset($_GET['page'])) {
    $pageToLoad = $_GET['page'];
} else {
    $pageToLoad = 'consultavcardsAnon.php';
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

    <title>EasyVCARDS - Anôniomo</title>
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
            <img src="imgs/perfilvazio.png" class="custom-image">
            <div class="custom-text">
                <p class="custom-text-line">Usuário</p>
                <p class="custom-text-line2">Anônimo</p>
            </div>
        </div>
        </img>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="#" onclick="mostrarAlerta()">
                            <i class='bx bx-user-circle icon' title="Perfil"></i>
                            <span class="text nav-text">Perfil</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#" data-page="consultaeventosAnon.php">
                            <i class='bx bx-store-alt icon' title="Eventos"></i>
                            <span class="text nav-text">Eventos</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#" data-page="consultavcardsAnon.php">
                            <i class='bx bx-news icon' title="Vcards"></i>
                            <span class="text nav-text">Vcards</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#" onclick="mostrarAlerta()">
                            <i class='bx bx-star icon' title="Favoritos"></i>
                            <span class="text nav-text">Favoritos</span>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="bottom-content">

                <li class="nav-link">
                    <a href="login.php">
                        <i class='bx bx-log-in icon logout-icon' title="Login"></i>
                        <span class="text nav-text">Login</span>
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
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="mostrarAlerta()" title="Perfil">
                    <i class='bx bx-user-circle'></i>
                </button>
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sistAnon.php?page=consultaeventosAnon.php'" title="Eventos">
                    <i class='bx bx-store-alt'></i>
                </button>
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='sistAnon.php?page=consultavcardsAnon.php'" title="Vcards">
                    <i class='bx bx-news'></i>
                </button>
                <button class="logout-button" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="mostrarAlerta()" title="Favoritos">
                    <i class='bx bx-star'></i>
                </button>
                <button class="logout-button3" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="window.location.href='login.php'" title="Login">
                    <i class='bx bx-log-in'></i>
                </button>

                <button class="logout-button2" onmouseover="changeBackgroundColor(this, true)" onmouseout="changeBackgroundColor(this, false)" onclick="toggleDropdown()">
                    <i class='bx bx-menu'></i>

                    <div class="dropdown" id="dropdown-menu">
                        <a href="#" title="Perfil" onclick="mostrarAlerta()"><i class='bx bx-user-circle' title="Perfil"></i></a>
                        <a href="sistAnon.php?page=consultaeventosAnon.php" title="Eventos"><i class='bx bx-store-alt' title="Eventos"></i></a>
                        <a href="sistAnon.php?page=consultavcardsAnon.php" title="Vcards"><i class='bx bx-news' title="Vcards"></i></a>
                        <a href="#" title="Favoritos" onclick="mostrarAlerta()"><i class='bx bx-star' title="Favoritos"></i></a>
                        <a href="login.php" title="Login"><i class='bx bx-log-in' title="Login"></i></a>
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

        function mostrarAlerta() {
            alert("Para utilizar esta função você deve estar logado. Por favor, efetue o login ou cadastre-se.");
        }
    </script>

</body>

</html>