<?php
    require_once("Zipar.class.php");
    require_once("db.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_POST['botao'])){
            $arq = $_FILES['arquivo']['name'];
            $arq = str_replace(" ","_",$arq);
            $arq = str_replace("-","_",$arq);
            $arq = str_replace("ç","c",$arq);
            if(file_exists("arquivos/$arq")) {
                $a = 1;
                while(file_exists("arquivos/[$a]$arq")){
                    $arq = "[".$a."]".$arq;
                }
            }
            if(move_uploaded_file($_FILES['arquivo']['tmp_name'], "arquivos/".$arq)){
                $zip = new Zipar();
                $zip->ziparArquivos($arq, $arq.".zip", "arquivos/");
                unlink("arquivos/$arq");
                $sqlInto = "INSERT INTO arquivo(nome) VALUES(:nome)";
                try{
                    $into = $db->prepare($sqlInto);
                    $into->bindValue(":nome", $arq.".zip", PDO::PARAM_STR);
                    if($into->execute()){
                        echo "<div> upload realizado com sucesso<span>x</span></div>";
                    }
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                
                
            }else{
                echo "<div> falha<span>x</span></div>";
            }
        }
    ?>
    <div>
        <form action="" enctype="multipart/form-data" name="upload" method="POST">
            <input type="file" name="arquivo">
            <input type="submit" name="botao" value="enviar">
        </form>
    </div>
    <br>
    <div>
    <table cellpadding="3" cellspacing="0" border="0">
        <thead>
        <tr>
            <td width="30">ID</td>
            <td width="200">Nome</td>
            <td width="130">Download</td>
        </tr>
        </thead>
        <tbody>
             <?php
                $sqlReady = "SELECT * FROM arquivo";
                try{
                    $ready = $db->prepare($sqlReady);
                    $ready->execute();
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                while($rs = $ready->fetch(PDO::FETCH_OBJ)){

                ?>
            <tr>
                <td><?php echo $rs->id ?></td>
                <td><?php echo $rs->nome ?></td>
                <td><a href="arquivos/<?php echo $rs->nome ?>">Download</a></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    
    </table>
        
    </div>
</body>
</html>