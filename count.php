<?php

error_reporting(0);
session_start();

if(empty($_SESSION["logado"])){
echo "<div class='text-center text-danger'><b>PARA USAR NOSSOS CHECKER É NECESSARIO REALIZAR LOGIN</b></div>";
exit();
}

$chave = $_SESSION["chave"];
$auth_token = $_SESSION["auth_token"];

require_once('../includes/conexao.php');

$busca = mysqli_query($conexao, "SELECT * FROM usuarios WHERE chave = '$chave'");

if(mysqli_num_rows($busca)  < 1){
echo "<div class='text-danger'><b>LOGIN NAO ENCONTRADO, REALIZE O LOGIN E TENTE NOVAMENTE</b></div>";
mysqli_close($conexao);
exit();
}

$dados = mysqli_fetch_assoc($busca);

if($dados["auth_token"] !== $auth_token){
echo "<div class='text-danger'><b>NOVO LOGIN DETECTADO, ACESSO BLOQUEADO</b></div>";
mysqli_close($conexao);
exit();
}

$usuario = trim($dados["usuario"]);
$saldo = trim($dados["saldo"]);
$lives = trim($dados["lives"]);

if($saldo < 1){
exit('<span class="badge badge-danger"> RECARREGUE MAIS SALDO PARA UTILIZAR.</span></br>'); 
mysqli_close($conexao);
exit();
}

function debitar($valor){
global $conexao, $saldo, $chave, $lives;

$troco = $saldo - $valor;

if(is_numeric($troco)){

mysqli_query($conexao, "UPDATE usuarios SET saldo = '$troco' WHERE chave = '$chave'");

if(mysqli_affected_rows($conexao) > 0){

$total_lives = intval($lives +1);
$_SESSION["saldo"] = $troco;
$_SESSION["lives"] = $total_lives;
mysqli_query($conexao, "UPDATE usuarios SET lives = '$total_lives' WHERE chave = '$chave'");

        }
   }
}

$proxy1 = "p.webshare.io:80";
$proxy2 = "mobxqfak-BR-rotate:alcolngusz6z";

?>