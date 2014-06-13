<?php
/*
 *@name         Acciones sobre los archivos
 *@author       Gerardo Lara
 *@version      2.0.0
*/

class funciones{
    
    private $path;
    /*
     *@method   Funcion para copiar archivos y/o directorios
     *@return   resultado de la operacion
    */
    public function copiarArchivos($archivosA,$destino,$rutaActual){
        $archivosA=explode(",",$archivosA);
        $resultado="";
        for($i=0;$i<count($archivosA);$i++){
            $archivo=$rutaActual."/".$archivosA[$i];
            //$this->copia($archivo,$destino);
	    if(is_dir($archivo)){//en caso de que sea directorio
		//se verifica su existencia en la carpeta destino
		if(file_exists($destino."/".$archivosA[$i])){//en caso de existir mandar una advertencia de sobreescritura
		    $resultado="%%%%";
		}else{//el directorio no existe, se procede a su creacion
		    $resultado=$this->crearDirectorio($archivosA[$i],$destino);
		    if($resultado==1){
			$resultado="Copia Realizada";
		    }
		}
	    }else{//en caso de que sea archivo
		$resultado="ARCHIVO";
	    }
        }
        return $resultado;
    }
    
    //Recojo el valor de donde copio y donde tengo que copiar
    /*
     *Funcion para copiar de manera recursiva esta funcion esta en prueba
    */
    function copia($dirOrigen, $dirDestino){
	//Creo el directorio destino
	mkdir($dirDestino, 0777, true);
	//abro el directorio origen
	
	if ($vcarga = opendir($dirOrigen)){
	    while($file = readdir($vcarga)){ //lo recorro enterito
		if ($file != "." && $file != "..") {//quito el raiz y el padre
		    echo "<b>$file</b>"; //muestro el nombre del archivo
		    if (!is_dir($dirOrigen.$file)){ //pregunto si no es directorio
			if(copy($dirOrigen.$file, $dirDestino.$file)) //como no es directorio, copio de origen a destino
			{
			    echo " COPIADO!";
			}else{
			    echo " ERROR!";
			}
		    }else{
			echo " — directorio — <br />"; //era directorio llamo a la función de nuevo con la nueva ubicación
			copia($dirOrigen.$file."/", $dirDestino.$file."/");
		    }
		    echo "<br />";
		}
	    }
	    closedir($vcarga);
	}
    }
    
    
    /*
     *@method   Funcion para renombrar archivos y/o directorios
     *@return   resultado de la operacion
    */
    public function renombrarDirectorio($directorio,$idInput,$idEnlace,$nuevoNombre,$rutaActual){
	if(file_exists($rutaActual."/".$nuevoNombre)){
            $resultado="%%%%";
        }else{
            if(rename($rutaActual."/".$directorio,$rutaActual."/".$nuevoNombre)){
                $resultado=$rutaActual;
            }else{
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
			if($archivo != "." && $archivo != ".." && $archivo != ".DS_Store"){
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