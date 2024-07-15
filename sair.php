<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['senha']);
unset($_SESSION['nome']);
unset($_SESSION['tipo']);
unset($_SESSION['id']);
header("Location: login.php");
