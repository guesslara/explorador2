<?php
/*
 *@name         Acciones sobre los archivos
 *@author       Gerardo Lara
 *@version      2.0.0
*/

class funciones{
    
    private $path;
    
    /*
     *@method   Leer el contenido de un directorio dado
     *@return   listado del directorio
    */
    public function crearDirectorio($nombredir,$path){
        strip_tags($nombredir);
	$directorioNuevo=$path."/".strtoupper($nombredir);
        if (file_exists($directorioNuevo)){
	    $mensaje="La carpeta ya existe en el directorio";
	}else{
	    if(mkdir($directorioNuevo, 0777)){
		$mensaje="Directorio Creado";		
	    }else{
		$mensaje="Error al crear el directorio, verifique la informacion.";
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
            $this->path=$path;
            $directorio=dir($path);
            if(!is_dir($path)){
                    echo "El directorio no existe en la ruta especificada.";
            }else{
                $carpeta = @scandir($path);
                if (count($carpeta) > 2){
                    $i=0; $contenidoDir=array();
		    while ($archivo = $directorio->read()){		    
			if($archivo != "." && $archivo != ".."){
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $contenidoDir[$i][1]=$archivo;
                            $contenidoDir[$i][2]=filetype($path."/".$archivo);//tipo de archivo
                            $contenidoDir[$i][3]=filesize($path."/".$archivo);//tamaño del archivo
                            $contenidoDir[$i][4]=fileperms($path."/".$archivo);//permisos del archivo
                            $contenidoDir[$i][5]=fileatime($path."/".$archivo);//ultimo acceso del archivo
                            $contenidoDir[$i][6]=filectime($path."/".$archivo);//ultimo cambio del archivo
                            $contenidoDir[$i][7]=finfo_file($finfo,$path."/".$archivo);
                            $i+=1;
			}
                        
		    }
                    
                    
                    /*
                    sort($directorios);
                    sort($archivos);
                    $archivosLista=implode(",",array_merge($directorios,$archivos));
                    */
		    $directorio->close();
                }else{
		    echo "<center><p><h4>El directorio esta vacio</h4></p></center>";
		}
            }
            return $contenidoDir;
        }catch(Exception $e){
            echo "Error al leer el directorio."; 
        }
    }
    
    
    
}//fin de la clase


    $obj=new funciones();
    $contenidoDir=$obj->leerDirectorio("documentos");
    echo "<pre>";
    print_r($contenidoDir);
    echo "</pre>";
    
    //$carpeta=$obj->crearDirectorio("pruebaX","documentos");
    //echo $carpeta;
?>