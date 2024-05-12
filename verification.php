<?php

error_reporting(0);
session_start();

if(empty($_SESSION["logado"])){
header("Location: ../");
exit();
}


?>