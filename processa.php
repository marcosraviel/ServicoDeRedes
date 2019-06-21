<?php
    if(isset($_POST['botao'])){
        $admin = $_POST['usuario'];
        $senha = $_POST['senha'];
        if($admin  == "admin") {
            
            include_once("upload.php");
        }
        else{
            echo "<h2>Usuario e senha incorretas</h2>";
            echo "<a href='login.html'>voltar</a>";
        }
    }
    echo "<h2>Dados Invalidos</h2>";
    echo "<a href='login.html'>voltar</a>";
?>