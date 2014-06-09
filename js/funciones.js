/*
 *Funciones en javascript para el explorador
*/
var path="" ;
var nombreFuncion="";
function actualizarDirectorio(path){
    ocultarVistaPrevia();
    $("#ubicacionDirectorios").html(path);
    $("#hdnRutaActual").attr("value",path);
    //ajaxApp("browserArchivos","auxVisor.php","action=abrirDirectorio&path="+path,"POST");
    ajaxAppExplorador("leerDirectorio","controlador.php","action=abrirDirectorio&path="+path,"POST");
}
function abrirDirectorio(path){
    //ajaxAppPlataforma("dibujaGrupos",url,"","POST");   
    $("#ubicacionDirectorios").html(path);
    $("#hdnRutaActual").attr("value",path);
    ajaxAppExplorador("leerDirectorio","controlador.php","action=abrirDirectorio&path="+path,"POST");
    $('#btnAtras').show();
}
function escribirContenido(datos){
    //<input type='checkbox' name='chkFiles' id='"+chk+"' style='margin-left: 3px;' onclick='seleccionarCheck(this.id)' />
    $("#browserArchivos").html("");
    contenidoDirectorio=datos.split("|");//partimos la cadena
    for(var i=0;i<contenidoDirectorio.length;i++){
        nombreFuncion="";  funcionEliminar="";
        valores=contenidoDirectorio[i].split(",");
        if(valores[0]!="????"){
            div="div_"+i;  txt="txt_"+i; chk="chk_"+i; divOpciones="divOpciones_"+i;  idNombre="nombreFile_"+i; evento="enter"; boton="boton_"+i;
            pathActual=$("#hdnRutaActual").val();
            path=pathActual+"/"+valores[2];
            if(valores[0]=="dir"){//se arman las funciones para las vistas previas o abrir elementos
                nombreFuncion="<div class='contenedorFile' onclick='abrirDirectorio(\""+path+"\")'>";
                funcionEliminar="<div id='"+divOpciones+"' class='checkFile'><a href='#' onclick='eliminaDirectorio(\""+valores[2]+"\")' title='Eliminar'><img src='./img/icon_delete.gif' class='imgCarpetasFiles' border='0' /></a>&nbsp;&nbsp;<a href='#' onclick='renombrarDirectorio(\""+valores[2]+"\",\""+txt+"\",\""+idNombre+"\",\""+boton+"\")' title='Renombrar'><img src='./img/duplicate.png' class='imgCarpetasFiles' border='0' /></a></div>";
            }else{
                nombreFuncion="<div class='contenedorFile' onclick='mostrarArchivo(\""+path+"\")'>";
                funcionEliminar="<div id='"+divOpciones+"' class='checkFile'><a href='#' onclick='eliminarArchivo(\""+valores[2]+"\")' title='Eliminar'><img src='./img/icon_delete.gif' class='imgCarpetasFiles' border='0' /></a>&nbsp;&nbsp;<a href='#' onclick='renombrarDirectorio(\""+valores[2]+"\",\""+txt+"\",\""+idNombre+"\",,\""+boton+"\")'  title='Renombrar'><img src='./img/duplicate.png' class='imgCarpetasFiles' border='0' /></a></div>";
            }
            funcionRenombrar="<div id='"+idNombre+"' class='nombreFileDir'>"+valores[2]+"</div><div id='"+div+"'><input type='text' name='"+txt+"' id='"+txt+"' value='"+valores[2]+"' style='display:none;' /></div>";
            
            //se arman las estructuras para los diferentes elementos del directorio
            elemento="<div class='contenedorArchivo'>";
            elemento+="<div class='limiteCarpeta'>";
            elemento+=funcionEliminar;
            elemento+=nombreFuncion;
            elemento+="<div class='imagenFile'></div>";
            elemento+="</div>";
            elemento+="</div>";
            elemento+="<div class='nombreFileDir'><span id='"+idNombre+"'>"+valores[2]+"</span></div><div id='"+div+"'><input type='text' name='"+txt+"' id='"+txt+"' value='"+valores[2]+"' style='display:none;' /><input type='button' id='"+boton+"' value='Guardar...' onclick='guardarNuevoNombreDir(\""+valores[2]+"\",\""+txt+"\",\""+idNombre+"\",\""+evento+"\")' style='display:none;' /></div>";
            elemento+="</div>";
            $("#browserArchivos").append(elemento);
        }else{
            $("#browserArchivos").html();
            $("#browserArchivos").append("<center><h3>El directorio se encuentra vacio.</h3></center>");
        }
        $('#hdnCantElementos').attr('value',(i+1));
    }
}
function crearDirectorio(){
    var directorio=prompt("Introduzca el nombre del Directorio a Crear");
    if(directorio=="" || directorio == null || directorio==undefined){
	alert("Verifique la informacion proporcionada e intentelo de nuevo");
    }else{
	pathActual=$("#hdnRutaActual").val();
	//alert("action=crearDir&nombreDir="+directorio+"&path="+pathActual);
        ajaxAppExplorador("crearDirectorio","controlador.php","action=crearDir&nombreDir="+directorio+"&path="+pathActual,"POST");
    }
    return false;
}
function mensajes(accion,datos){
    if(accion=="crearDir" && datos=="1"){//creado
        alert("Directorio creado");
        actualizarDirectorio();
    }else if(accion=="crearDir" && datos=="0"){//error al crear el directorio
        alert("Error, al crear el directorio indicado");
    }else if(accion=="crearDir" && datos=="11"){
        alert("La carpeta ya existe en el directorio");
    }
    pathActual=$("#hdnRutaActual").val();
    actualizarDirectorio(pathActual);
}
function retrocederDirectorio(){
    rutaActual=$("#hdnRutaActual").val();    
    //ajaxApp("browserArchivos","auxVisor.php","action=retrocederDirectorio&raizDirectorio="+raizDirectorio+"&rutaActual="+rutaActual,"POST");
    ajaxAppExplorador("retrocederDirectorio","controlador.php","action=retrocederDirectorio&raizDirectorio="+raizDirectorio+"&rutaActual="+rutaActual,"POST");
}
function seleccionarCheck(idElemento){
    //alert(idElemento);
    $("#browserArchivos").css("width","70%");//se cambia de tamaño el div de los archivos
    $("#propiedades").show();
}
function editarContenido(){
    cantEditar=parseInt($("#hdnCantElementos").val());
    console.log(cantEditar);
    for(i=0;i<cantEditar;i++){
	divEditar="#divOpciones_"+i;
	$(divEditar).show();
    }
    $("#btnEditar1").hide();
    $("#btnEditar2").show();
}
function finEditarContenido(){
    cantEditar=parseInt($("#hdnCantElementos").val());
    for(i=0;i<cantEditar;i++){
        divEditar="#divOpciones_"+i;
        inEditar="#inputEditar"+i;
        $(divEditar).hide();
        $(inEditar).hide();
    }
    $("#btnEditar2").hide();        
    $("#btnEditar1").show();
    cerrarVistaPrevia();
}
function eliminaDirectorio(directorio){
    if(confirm("Realmente desea ELIMINAR: "+directorio)){
        rutaActual=$("#hdnRutaActual").val();
        //ajaxApp("browserArchivos","auxVisor.php","action=eliminaDir&directorioEliminar="+directorio+"&rutaActual="+rutaActual,"POST");
        ajaxAppExplorador("eliminarDirectorio","controlador.php","action=eliminaDir&directorioEliminar="+directorio+"&rutaActual="+rutaActual,"POST");
    }else{
        alert("Opcion invalida");
    }
}
function eliminarArchivo(archivo){
    if(confirm("Realmente desea ELIMINAR: "+archivo)){
        rutaActual=$("#hdnRutaActual").val();
        //ajaxApp("browserArchivos","auxVisor.php","action=eliminaFile&archivoEliminar="+archivo+"&rutaActual="+rutaActual,"POST");
        ajaxAppExplorador("eliminarArchivo","controlador.php","action=eliminaFile&archivoEliminar="+archivo+"&rutaActual="+rutaActual,"POST");
    }else{
        alert("Opcion invalida");
    }
}
function renombrarDirectorio(directorio,idInput,idEnlace,boton){
    $("#"+idEnlace).hide();
    $("#"+idInput).show();
    $("#"+idInput).focus();
    $("#"+boton).show();
}

function guardarNuevoNombreDir(directorio,idInput,idEnlace,evento){
    //alert(evento);
    //if(evento=="enter"){
        //se recupera el nuevo nombre
        nuevoNombre=$("#"+idInput).val();
        rutaActual=$("#hdnRutaActual").val();
        opciones="action=renombrarDirectorio&directorio="+directorio+"&idInput="+idInput+"&idEnlace="+idEnlace+"&nuevoNombre="+nuevoNombre+"&rutaActual="+rutaActual;
        //ajaxApp("browserArchivos","auxVisor.php",opciones,"POST");
        ajaxAppExplorador("renombrar","controlador.php",opciones,"POST");
        finEditarContenido();
    //}	
}

function mostrarFormSubirArchivos(){
    rutaActual=$("#hdnRutaActual").val();
    $("#subirArchivos").show();
    //ajaxApp("detalleSubirArchivos","auxVisor.php","action=mostrarFormArchivos&rutaActual="+rutaActual,"POST");
    //ajaxAppExplorador("subirArchivos","controlador.php","action=mostrarFormArchivos&rutaActual="+rutaActual,"POST")
    frame="<iframe src='formUpArchivos.php?rutaActual="+rutaActual+"' style='background:#FFF; width:99.5%; height: 99%; overflow:auto;'></iframe>";
    $("#detalleSubirArchivos").html("");
    $("#detalleSubirArchivos").append(frame);
}
