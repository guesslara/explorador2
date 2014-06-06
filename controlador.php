<?php
/*
 *@name         Controlador de Acciones sobre los archivos
 *@author       Gerardo Lara
 *@version      2.0.0
*/
    include "funciones.php";
    $obJFunciones=new funciones();
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    switch($_POST["action"]){
        case "abrirDirectorio":        
            echo "abrir directorio<br>";
            $path=trim($_POST["path"]);
            $contenidoDir=$obJFunciones->leerDirectorio($path);
            echo "<pre>";
            print_r($contenidoDir);
            echo "</pre>";
            $elementos="";
            for($i=0;$i<count($contenidoDir);$i++){
                if($elementos==""){
                    $elementos=$contenidoDir[$i][0].",".
                            $contenidoDir[$i][1].",".
                            $contenidoDir[$i][2].",".
                            $contenidoDir[$i][3].",".
                            $contenidoDir[$i][4].",".
                            $contenidoDir[$i][5].",".
                            $contenidoDir[$i][6];    
                }else{
                    $elementos.="|".$contenidoDir[$i][0].",".
                            $contenidoDir[$i][1].",".
                            $contenidoDir[$i][2].",".
                            $contenidoDir[$i][3].",".
                            $contenidoDir[$i][4].",".
                            $contenidoDir[$i][5].",".
                            $contenidoDir[$i][6];
                }
                
            }
            echo $elementos;
        break;
    }
?>