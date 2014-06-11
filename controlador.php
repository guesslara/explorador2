<?php
/*
 *@name         Controlador de Acciones sobre los archivos
 *@author       Gerardo Lara
 *@version      2.0.0
*/
    include "funciones.php";
    $obJFunciones=new funciones();
    switch($_POST["action"]){
        case "abrirDirectorio":
            $path=trim($_POST["path"]);
            $contenidoDir=$obJFunciones->leerDirectorio($path);
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
        case "crearDir":
            $nombreDir=trim($_POST["nombreDir"]);
            $path=trim($_POST["path"]);
            $mensaje=$obJFunciones->crearDirectorio($nombreDir,$path);
            echo $mensaje;
        break;
        case "retrocederDirectorio":
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";*/
            $raizDirectorio=$_POST["raizDirectorio"];
            $rutaActual=$_POST["rutaActual"];
            $retroceso=$obJFunciones->retrocederDirectorio($raizDirectorio,$rutaActual);
            echo $retroceso;
        break;
        case "eliminaDir":
            $directorioEliminar=$_POST["directorioEliminar"];
            $rutaActual=$_POST["rutaActual"];
            $mensaje=$obJFunciones->eliminarDirectorio($directorioEliminar,$rutaActual);
            echo $mensaje;
        break;
        case "eliminaFile":
            $archivoEliminar=$_POST["archivoEliminar"];
            $rutaActual=$_POST["rutaActual"];
            $mensaje=$obJFunciones->eliminarArchivo($archivoEliminar,$rutaActual);
            echo $mensaje;
        break;
        case "renombrarDirectorio":
            $directorio=$_POST["directorio"];
            $idInput=$_POST["idInput"];
            $idEnlace=$_POST["idEnlace"];
            $nuevoNombre=$_POST["nuevoNombre"];
            $rutaActual=$_POST["rutaActual"];
            $mensaje=$obJFunciones->renombrarDirectorio($directorio,$idInput,$idEnlace,$nuevoNombre,$rutaActual);
            echo $mensaje;
        break;
        case "mostrarFormArchivos":
            echo $rutaActual=trim($_POST["rutaActual"]);
        break;
        case "accionesArchivos":
            $operacion=$_POST["operacion"];
            $destino=$_POST["destino"];
            $archivosA=$_POST["archivosA"];
            $rutaActual=$_POST["rutaActual"];
            if($operacion=="copiar"){
                $resultado=$obJFunciones->copiarArchivos($archivosA,$destino,$rutaActual);    
            }
            echo $resultado;
        break;
    }
?>