<?php
/*
 *@name         Acciones sobre los archivos
 *@author       Gerardo Lara
 *@version      2.0.0
*/

class funciones{
    
    private $path;
    /*
     *@method   Funcion para renombrar archivos y/o directorios
     *@return   resultado de la operacion
    */
    function renombrarDirectorio($directorio,$idInput,$idEnlace,$nuevoNombre,$rutaActual){
	if(file_exists($rutaActual."/".$nuevoNombre)){
            //echo "<script type='text/javascript'> alert('El directorio ya existe'); </script>";
            $resultado="%%%%";
        }else{
            if(rename($rutaActual."/".$directorio,$rutaActual."/".$nuevoNombre)){
                //echo "<script type='text/javascript'> actualizarDirectorio('".$rutaActual."'); $('#".$idInput."').hide(); $('#".$idEnlace."').show(); </script>";
                $resultado=$rutaActual;
            }else{
                //echo "<script type='text/javascript'> alert('Error al cambiar el nombre del directorio'); </script>";
                $resultado=0;
            }
        }
        return $resultado;
    }
    /*
     *@method   Funcion para eliminar archivo
     *@return   resultado de la operacion
    */
    public function eliminarArchivo($archivoEliminar,$rutaActual){
        if(unlink($rutaActual."/".$archivoEliminar)){
	    //echo "<script type='text/javascript'> alert('Archivo Borrado'); actualizarDirectorio('".$rutaActual."'); </script>";
            $resultado=$rutaActual;
	}else{
	    //echo "<script type='text/javascript'> alert('Error al ejecutar la operacion'); </script>";
            $resultado=0;
	}
        return $resultado;
    }
    /*
     *@method   Funcion para eliminar directorio
     *@return   resultado de la operacion
    */
    public function eliminarDirectorio($directorio,$rutaActual){
	//se escanea el directorio
	$carpeta = @scandir($rutaActual."/".$directorio);
	if (count($carpeta) > 2){
	    //echo "El directorio contiene Archivos, verifique la informacion";
            $resultado="%%%%";
	}else{
	    if(rmdir($rutaActual."/".$directorio)){
		//echo "<script type='text/javascript'> abrirDirectorio('".$rutaActual."'); </script>";
                $resultado=$rutaActual;
	    }else{
		//echo "<script type='text/javascript'> alert('Error al ejecutar la operacion'); </script>";
                $resultado=0;
	    }
	}
        return $resultado;
    }
    /*
     *@method   Funcion para retroceder directorios
     *@return   listado del directorio anterior
    */
    public function retrocederDirectorio($raizDirectorio,$rutaActual){	
	$rutaActual=explode("/",$rutaActual);	
	$totalPosiciones=count($rutaActual);
	$nuevaRuta="";
	for($i=0;$i<($totalPosiciones-1);$i++){
	    if($nuevaRuta==""){
		$nuevaRuta=$rutaActual[$i];
	    }else{
		$nuevaRuta=$nuevaRuta."/".$rutaActual[$i];
	    }	    
	}	
	if($nuevaRuta!=$raizDirectorio){
	    //echo "<script type='text/javascript'> abrirDirectorio('".$nuevaRuta."'); </script>";
            $mensaje=$nuevaRuta;
	}else if($nuevaRuta==$raizDirectorio){
	    //echo "<script type='text/javascript'> abrirDirectorio('".$raizDirectorio."'); $('#btnAtras').hide();</script>";
            $mensaje=$raizDirectorio;
	}
        return $mensaje;
    }
    
    /*
     *@method   Leer el contenido de un directorio dado
     *@return   listado del directorio
    */
    public function crearDirectorio($nombredir,$path){
        strip_tags($nombredir);
	$directorioNuevo=$path."/".strtoupper($nombredir);
        if (file_exists($directorioNuevo)){
	    $mensaje=11;
	}else{
	    if(mkdir($directorioNuevo, 0777)){
		$mensaje=1;		
	    }else{
		$mensaje=0;
	    }
	}
        return $mensaje;
    }
    
    /*
     *@method   Leer el contenido de un directorio dado
     *@return   listado del directorio
    */
    public function leerDirectorio($path){
        try{
            $contenidoDir=array();
            $this->path=$path;
            $directorio=dir($path);
            if(!is_dir($path)){
                $contenidoDir[0][0]="????";
            }else{
                $carpeta = scandir($path,0);
                if (count($carpeta) > 2){
                    $i=0; 
		    while ($archivo = $directorio->read()){		    
			if($archivo != "." && $archivo != ".."){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $contenidoDir[$i][0]=filetype($path."/".$archivo);//tipo de archivo;
                            $contenidoDir[$i][1]=finfo_file($finfo,$path."/".$archivo);
                            $contenidoDir[$i][2]=$archivo;
                            $contenidoDir[$i][3]=filesize($path."/".$archivo);//tamaño del archivo
                            $contenidoDir[$i][4]=fileperms($path."/".$archivo);//permisos del archivo
                            $contenidoDir[$i][5]=fileatime($path."/".$archivo);//ultimo acceso del archivo
                            $contenidoDir[$i][6]=filectime($path."/".$archivo);//ultimo cambio del archivo
                            
                            $i+=1;
			}
                        
		    }
                    sort($contenidoDir);
                    
		    $directorio->close();
                }else{
		    $contenidoDir[0][0]="????";
		}
            }
            return $contenidoDir;
        }catch(Exception $e){
            echo "Error al leer el directorio."; 
        }
    }
    
    
    
}//fin de la clase


    //$obj=new funciones();
    /*$contenidoDir=$obj->leerDirectorio("documentos");
    echo "<pre>";
    print_r($contenidoDir);
    echo "</pre>";
    */
    //$carpeta=$obj->crearDirectorio("pruebaX","documentos");
    //echo $carpeta;
    //$mensaje=$obj->retrocederDirectorio("documentos","documentos/A1");
    //echo $mensaje;
?>