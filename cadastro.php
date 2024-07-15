<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<title>EasyVCARDS - Cadastro</title>
</head>

<body>
	<button class="botao-voltar" onclick="window.location.href='login.php'">VOLTAR</button>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="testCadastro.php" method="POST">
					<span class="login100-form-title p-b-26">
						<span class="gradient-text">CADASTRO</span>
					</span>
					<br>
					<div class="wrap-input100 validate-input" data-validate="Insira um nome.">
						<input class="input100 <?php echo isset($_GET['nome']) && !empty($_GET['nome']) ? 'has-val' : ''; ?>" type="text" name="nome" value="<?php echo isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : ''; ?>">
						<span class="focus-input100" data-placeholder="Nome Completo"></span>
					</div>
					<p class="tipo-input">Sexo:</p>
					<input type="radio" id="feminino" name="genero" value="Feminino" <?php echo (isset($_GET['genero']) && $_GET['genero'] === 'feminino') ? 'checked' : ''; ?> required>
					<label class="tipo-input" for="feminino">Feminino </label>
					<input type="radio" id="masculino" name="genero" value="Masculino" <?php echo (isset($_GET['genero']) && $_GET['genero'] === 'masculino') ? 'checked' : ''; ?> required>
					<label class="tipo-input" for="masculino">Masculino </label>
					<input type="radio" id="outro" name="genero" value="Outro" <?php echo (isset($_GET['genero']) && $_GET['genero'] === 'outro') ? 'checked' : ''; ?> required>
					<label class="tipo-input" for="outro">Outro</label>
					<br><br>
					<label class="tipo-input" for="data_nascimento">Nascimento:</label>
					<input class="tipo-input" type="date" name="data_nascimento" id="data_nascimento" required value="<?php echo isset($_GET['data_nascimento']) ? htmlspecialchars($_GET['data_nascimento']) : ''; ?>">
					<br><br>
					<div class="wrap-input100 validate-input" data-validate="Insira uma cidade.">
						<input class="input100 <?php echo isset($_GET['cidade']) && !empty($_GET['cidade']) ? 'has-val' : ''; ?>" type="text" name="cidade" value="<?php echo isset($_GET['cidade']) ? htmlspecialchars($_GET['cidade']) : ''; ?>">
						<span class="focus-input100" data-placeholder="Cidade"></span>
					</div>
					<div class="input-group">
						<label class="tipo-input" for="tipo">Tipo de Usuário:</label>
						<select class="tipo-input" id="tipo" name="tipo" onchange="toggleCodigoField()">
							<option value="Visitante" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] === 'Visitante') ? 'selected' : ''; ?>>Visitante</option>
							<option value="Administrador" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
							<option value="Organizador" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] === 'Organizador') ? 'selected' : ''; ?>>Organizador</option>
							<option value="Participante" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] === 'Participante') ? 'selected' : ''; ?>>Participante</option>
						</select>
					</div>
					<br><br>
					<div id="validacao2">
						<?php
						if (isset($_GET['mensagem2'])) {
							echo '<p class="login-incorreto">' . htmlspecialchars($_GET['mensagem2']) . '</p>';
							echo '<br><br>';
						}
						?>
					</div>
					<div class="wrap-input100 validate-input" id="codigoField" style="display: none;">
						<input class="input100 <?php echo isset($_GET['codigo']) && !empty($_GET['codigo']) ? 'has-val' : ''; ?>" type="text" name="codigo" id="codigo" value="<?php echo isset($_GET['codigo']) ? htmlspecialchars($_GET['codigo']) : ''; ?>">
						<span class="focus-input100" data-placeholder="Código Fornecido pelo Administrador"></span>
					</div>
					<div id="validacao">
						<?php
						if (isset($_GET['mensagem'])) {
							echo '<p class="login-incorreto">' . htmlspecialchars($_GET['mensagem']) . '</p>';
							echo '<br>';
						}
						?>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Formato válido: aa@bb.cc">
						<input class="input100 <?php echo isset($_GET['email']) && !empty($_GET['email']) ? 'has-val' : ''; ?>" type="text" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Insira uma senha.">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye-off"></i>
						</span>
						<input class="input100 <?php echo isset($_GET['senha']) && !empty($_GET['senha']) ? 'has-val' : ''; ?>" type="password" name="senha" value="<?php echo isset($_GET['senha']) ? htmlspecialchars($_GET['senha']) : ''; ?>">
						<span class="focus-input100" data-placeholder="Senha"></span>
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="submit" type="submit">
								Cadastrar
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/cadastro.js"></script>
</body>

</html>