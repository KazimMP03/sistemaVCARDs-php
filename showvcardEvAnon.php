<?php

include_once('config.php');

// Obtém o valor de id_vcard da URL
$id_vcard = isset($_GET['id']) ? $_GET['id'] : null;

// Verifica se o id_vcard está definido
if ($id_vcard !== null) {
    // Atualiza a contagem de visualizações na tabela "vcards"
    $update_visualizacoes_sql = "UPDATE vcards SET visualizacoes = visualizacoes + 1 WHERE id = '$id_vcard'";
    $update_visualizacoes_result = $conexao->query($update_visualizacoes_sql);
}

$vcards_sql = "SELECT titulo, apresentacao, data_pub, categoria, redes, contato, patrocinadores, id_proprietario, data_vcard, nome_proprietario, imagem FROM vcards WHERE id = '$id_vcard'";
$vcards_result = $conexao->query($vcards_sql);

if (!$vcards_result) {
    die('Erro na consulta da tabela vcards: ' . $conexao->error);
}

// Extrai as informações da tabela "vcards"
$vcard_data = mysqli_fetch_assoc($vcards_result);

// Verifica se a coluna "imagem" está vazia e define o valor de $imagemvcard
$imagemvcard = empty($vcard_data['imagem']) ? 'imgs/imagemvcard1.png' : $vcard_data['imagem'];
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
        <a href="sistAnon.php?page=consultaeventosAnon.php" class="retbtn" title="Voltar"><i class='bx bxs-chevrons-left'></i></a>
        <?php
        include_once('config.php');

        // Obtém o valor de id_vcard da URL
        $id_vcard = isset($_GET['id']) ? $_GET['id'] : null;

        // Verifica se o id_vcard está definido
        if ($id_vcard !== null) {
            // Consulta para obter informações da tabela "vcards"
            $vcards_sql = "SELECT titulo, apresentacao, data_pub, categoria, redes, contato, patrocinadores, id_proprietario, data_vcard, nome_proprietario FROM vcards WHERE id = '$id_vcard'";
            $vcards_result = $conexao->query($vcards_sql);

            if (!$vcards_result) {
                die('Erro na consulta da tabela vcards: ' . $conexao->error);
            }

            // Extrai as informações da tabela "vcards"
            $vcard_data = mysqli_fetch_assoc($vcards_result);
        ?>

            <div class="containerbig" style="user-select: none;">
                <div class="flip-cardbig">
                    <div class="flip-card-innerbig">
                        <div class="flip-card-frontbig">
                            <div class="whitebgbig">
                                <div class="titulovcardbig">
                                    <p class="titulovcardbigp"><?php echo $vcard_data['titulo']; ?></p>
                                </div>
                            </div>
                            <div class="card-headerbig">
                                <img src="<?php echo $imagemvcard; ?>" alt="Avatar" class="card-imgbig">
                            </div>
                            <div class="descricaovcardbig">
                                <p><?php echo $vcard_data['apresentacao']; ?></p>
                            </div>
                            <div class="datavcardbig">
                                <p><?php echo date('d-m-Y', strtotime($vcard_data["data_vcard"])); ?></p>
                            </div>
                        </div>
                        <div class="flip-card-backbig">
                            <div class="backcardbig">
                                <p class="parag">CATEGORIA:</p>
                                <p><?php echo $vcard_data['categoria']; ?></p>
                                <br>
                            </div>
                            <div class="backcardbig">
                                <p class="parag">REDES SOCIAIS:</p>
                                <p><?php echo $vcard_data['redes']; ?></p>
                            </div>
                            <div class="backcardbig">
                                <p class="parag">CONTATO:</p>
                                <p><?php echo $vcard_data['contato']; ?></p>
                            </div>
                            <div class="backcardbig">
                                <p class="parag">PATROCINADORES:</p>
                                <p><?php echo $vcard_data['patrocinadores']; ?></p>
                            </div>
                            <div class="backcardbig">
                                <p class="parag">DATA DE PUBLICAÇÃO:</p>
                                <p><?php echo date('d-m-Y', strtotime($vcard_data["data_pub"])); ?></p>
                            </div>
                            <div class="backcardbig">
                                <p class="parag">PROPRIETÁRIO:</p>
                                <p><?php echo $vcard_data['nome_proprietario']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="containerbuttons">
                <a href="#" class="favvcard" title="Favoritar/Desfavoritar" onclick="mostrarAlerta()"><i class='bx bx-star'></i></a>
                <a href="#" class="favvcard" title="Like/Dislike" onclick="mostrarAlerta()"><i class='bx bx-heart'></i></a>
                <a href="#" class="favvcard" id="submitQrcode" title="QRCode"><i class='bx bx-qr'></i></a>
                <a href="#" class="favvcard compartilhar-link" data-id-vcard="<?php echo $id_vcard; ?>" title="Compartilhar Whatsapp"><i class='bx bxl-whatsapp'></i></a>

                <button onclick="GerarQRCode()" id="qrcodeButton" style="display: none;"></button>
            </div>

        <?php
        } else {
            // Caso id_vcard não esteja definido na URL, pode adicionar uma mensagem ou redirecionar para outra página
            echo 'ID do vcard não fornecido.';
        }
        ?>
    </div>

    <script>
        // Define a variável com o valor desejado
        var perfilText = "VISUALIZAR VCARD";

        // Envia a variável para a página pai (sistAnon.php)
        if (window.parent) {
            window.parent.updateNavbarText(perfilText);
        }

        // Variável para controlar o estado do QR Code
        var qrCodeAtivo = false;

        // Função para gerar ou remover o QR Code
        function GerarQRCode() {
            var descricaovcard = document.querySelector('.descricaovcardbig');

            // Se o QR Code estiver ativo, reverta para o conteúdo original
            if (qrCodeAtivo) {
                descricaovcard.innerHTML = '<p><?php echo $vcard_data["apresentacao"]; ?></p>';
                descricaovcard.style.backgroundColor = ''; // Remover cor de fundo personalizada
            } else {
                // Se o QR Code não estiver ativo, crie um elemento img para o QR Code
                descricaovcard.innerHTML = '<img id="QRCodeImage">';
                // Adicione a fonte da imagem do QR Code (substitua pela sua lógica de geração de QR Code)
                document.getElementById('QRCodeImage').src = 'caminho_para_sua_imagem_qr_code.png';
                descricaovcard.style.backgroundColor = 'white'; // Adicionar cor de fundo personalizada
            }

            // Inverta o estado do QR Code
            qrCodeAtivo = !qrCodeAtivo;

            GerarQRCodeImg();
        }

        // Restante do seu código JavaScript
        document.getElementById('submitQrcode').addEventListener('click', function() {
            GerarQRCode();
        });


        function GerarQRCodeImg() {
            var inputUsuario = "sistAnon.php?page=showvcard.php?id=<?php echo $id_vcard; ?>";
            var GoogleChartAPI = 'https://chart.googleapis.com/chart?cht=qr&chs=215x215&chld=H&chl=';
            var conteudoQRCode = GoogleChartAPI + encodeURIComponent(inputUsuario);
            document.querySelector('#QRCodeImage').src = conteudoQRCode;
        }

        $(document).ready(function() {
            // Captura o evento de clique no link do WhatsApp
            $('.compartilhar-link').on('click', function(event) {
                event.preventDefault(); // Impede o comportamento padrão do link

                // Obtém o ID do vcard a partir do atributo data
                var id_vcard = $(this).data('id-vcard');

                // Chama a função para atualizar compartilhamentos via Ajax
                atualizarCompartilhamentos(id_vcard);

                // Redireciona para o link do WhatsApp
                window.location.href = "https://api.whatsapp.com/send?text=http://localhost/DEFINITIVO/sistAnon.php?page=showvcard.php?id=" + id_vcard;
            });

            function atualizarCompartilhamentos(id_vcard) {
                // Envia uma requisição Ajax para o servidor
                $.ajax({
                    type: 'POST',
                    url: 'attcompartilhamentos.php', // Crie este arquivo PHP
                    data: {
                        id_vcard: id_vcard
                    },
                    success: function(response) {
                        console.log('Compartilhamento atualizado com sucesso');
                        // Você pode adicionar mais lógica aqui se necessário
                    },
                    error: function(error) {
                        console.error('Erro ao atualizar compartilhamentos:', error);
                    }
                });
            }
        });

        // Função para mostrar o alerta
        function mostrarAlerta() {
            alert("Para utilizar esta função você deve estar logado. Por favor, efetue o login ou cadastre-se.");
        }
    </script>


</body>

</html>