<?php
    try{
        $db = new PDO("mysql:dbname=arquivos; host=localhost; charset=utf8", "root","");
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>