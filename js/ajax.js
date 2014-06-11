/*
 *Funciones javascript
*/
function ajaxAppExplorador(accion,url,parametros,metodo){
    $.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
	    $("#cargadorAcciones").show().html("Cargando grupos..."); 
	},
	success:function(datos){ 
	    $("#cargadorAcciones").hide();
	    controladorAcciones(accion,datos);
	},
	timeout:90000000,
	error:function() {
	    $("#cargadorGeneral").hide();
	    $("#error").show();
	    $("#error_mensaje").html('Ocurrio un error al procesar la solicitud.');
	}
    });
}
function controladorAcciones(accion,datos){
    switch(accion){
	case "leerDirectorio":
	    escribirContenido(datos);
	break;
        case "crearDirectorio":
            mensajes("crearDir",datos);
        break;
        case "retrocederDirectorio":
            abrirDirectorio(datos)
	    if (datos==raizDirectorio) {
		$("#btnAtras").hide();
	    }
        break;
        case "eliminarDirectorio":
            if(datos=="%%%%"){
                alert("El directorio contiene Archivos, verifique la informacion");
            }else if(datos==0){
                alert("Error al ejecutar la operacion");
            }else{
                alert("Directorio Eliminado");
                abrirDirectorio(datos);
                finEditarContenido();
            }
        break;
        case "eliminarArchivo":
            if(datos==0){
                alert("Error al ejecutar la operacion");
            }else{
                alert('Archivo Borrado');
                abrirDirectorio(datos);
            }
        break;
        case "renombrar":
            if(datos==0){
                alert("Error al cambiar el nombre del directorio/archivo");
            }else if(datos=="%%%%"){
                alert("El directorio/archivo ya existe");
            }else{
                actualizarDirectorio(datos);
            }
        break;
	case "subirArchivos":
	    frame="<iframe src='formUpArchivos.php?rutaActual="+datos+"' style='background:#FFF; width:99.5%; height: 99%; overflow:auto;'></iframe>";
	    $("#subirArchivos2").html("");
	    $("#subirArchivos2").append(frame);
	break;
	case "accionesArchivos":
	    alert(datos);
	break;
    }
}