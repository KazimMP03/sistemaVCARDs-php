<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<title>Login - EasyVCARDS</title>
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="testLogin.php" method="POST">
					<span class="login100-form-title p-b-26">
						Easy <span class="gradient-text">VCARDS</span>
					</span>
					<span class="login100-form-title p-b-48">
						<img src="imgs/logomed.png" alt="Logo" width="200" height="170">
					</span>
					<div id="validacao" <?php $mensagem = isset($_GET['mensagem']) ? urldecode($_GET['mensagem']) : ''; ?>>
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
							<button class="login100-form-btn" name="submit">
								Entrar
							</button>
						</div>
					</div>
					<div class="text-center p-t-80">
						<span class="txt1">
							Ainda não tem uma conta?
						</span>
						<a class="txt2" href="cadastro.php">
							Cadastre-se!
						</a>
						<br>
						<span class="txt1">
							ou entre como
						</span>
						<br>
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" id="anonymousBtn">
								Anônimo
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/login.js"></script>
</body>

</html>