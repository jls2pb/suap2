<?php 
set_time_limit(0); 
include "conexao.php";

$sql = "SELECT * FROM tabela";
$resultado = $conexao->prepare($sql);
$sql2 = "SELECT * FROM procedimentos";
$resultado2 = $conexao->prepare($sql2);

if($resultado->execute()){
 
    $r = $resultado->fetchAll();
    if($resultado2->execute()){
       
        $r2 = $resultado2->fetchAll();
        foreach ($r as $x) {
        
            foreach ($r2 as $y) {
                
                if($y['cod'] == NULL){
                    $compare = NULL;
                    $compare = strcmp($y['nome_paciente'], $x['nome_paciente']);
                    if($compare == 0){
                        $a = $x['cod'];   
                        $b = $y['id']; 
                        $sql3 = "UPDATE procedimentos SET cod = '$a' WHERE id ='$b'";
                        $resultado3 = $conexao->prepare($sql3);
                        if($resultado3->execute()){
                            echo "Codigo ". $x['cod']."  cadastrado no procedimento :".$y['id'];     
                        }    
                    
                    }
                }  
            
            }
              
        
        }
    
    }else{
        echo "erro banco procedimentos";
    }
    
}else{
    echo "erro banco tabela";
}
?>