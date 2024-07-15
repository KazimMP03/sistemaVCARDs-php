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

if (empty($_SESSION['foto'])) {
    $fotoUsuario = "imgs/perfilvazio.png"; // Caminho da imagem padrão
} else {
    $fotoUsuario = $_SESSION['foto']; // Caminho da imagem do usuário
}

$sqlUser = "SELECT id, nome, tipo, sexo, datanasc, cidade, email FROM usuarios WHERE id = '$id'";
$result = $conexao->query($sqlUser);

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

    <div class="fundo">

        <div class="tablesuser">
            <table class="info-table">
                <tr>
                    <td class="center-image"><img src="<?php echo $fotoUsuario; ?>" class="custom-image2"></td>
                </tr>
                <tr>
                    <td>
                        <form enctype="multipart/form-data" action="sistVisit.php?page=perfilVisit.php" method="POST" id="uploadForm">
                            <input type="file" name="foto" id="foto" accept="image/*" style="display: none;">
                            <a href="#" class="editfoto" id="editFotoLink">EDITAR FOTO</a>
                            <input type="submit" value="Enviar" style="display: none;">
                        </form>
                    </td>
                </tr>
            </table>

            <?php
            if ($result->num_rows > 0) {
                echo "<table class='user-table'>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='label special-label'>NOME</td><td class='value'>" . $row["nome"] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td class='label special-label'>TIPO</td><td class='value'>" . $row["tipo"] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td class='label special-label'>SEXO</td><td class='value'>" . ucfirst($row["sexo"]) . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td class='label special-label'>NASCIMENTO</td><td class='value'>" . date('d-m-Y', strtotime($row["datanasc"])) . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td class='label special-label'>CIDADE</td><td class='value'>" . $row["cidade"] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td class='label special-label'>EMAIL</td><td class='value'>" . $row["email"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nenhum resultado encontrado.";
            }
            ?>
        </div>

        <div>
            <a href="sistVisit.php?page=editperfil.php?id=<?php echo $id; ?>" class="editbtn" title="Editar Perfil"><i class='bx bx-edit'></i></a>
        </div>

        <div class="aviso-foto-perfil">
        </div>

    </div>
    <script>
        // Define a variável com o valor desejado
        var perfilText = "DADOS PERFIL";

        // Envia a variável para a página pai (sistVisit.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        document.getElementById('editFotoLink').addEventListener('click', function() {
            document.getElementById('foto').click();
        });

        document.getElementById('foto').addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>


</body>

</html>