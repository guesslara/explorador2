/*
 *Funciones en javascript para el explorador
*/
var path="" ;
var nombreFuncion="";
var listadoDirectoriosActual=new Array();
var contenidoM=new Array();//array para elementos seleccionados
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
    listadoDirectoriosActual=[];
    contenidoDirectorio=datos.split("|");//partimos la cadena
    for(var i=0;i<contenidoDirectorio.length;i++){
        nombreFuncion="";  funcionEliminar="";
        valores=contenidoDirectorio[i].split(",");
        if(valores[0]!="????"){
            div="div_"+i;  txt="txt_"+i; chk="chk_"+i; divOpciones="divOpciones_"+i;  idNombre="nombreFile_"+i; evento="enter"; boton="boton_"+i;
            pathActual=$("#hdnRutaActual").val();
            path=pathActual+"/"+valores[2];
            if(valores[0]=="dir"){//se arman las funciones para las vistas previas o abrir elementos
		cssImagen="imagenFile";
                nombreFuncion="<div class='contenedorFile' onclick='abrirDirectorio(\""+path+"\")'>";
                funcionEliminar="<div id='"+divOpciones+"' class='checkFile'><input type='checkbox' value='"+valores[2]+"' name='chkFiles' id='"+chk+"' style='margin-left: 3px;' onclick='if(this.checked==true){seleccionarCheck(this.id,\""+valores[2]+"\")}else{quitarSeleccionCheck(this.id,\""+valores[2]+"\")}' /><a href='#' onclick='eliminaDirectorio(\""+valores[2]+"\")' title='Eliminar'><img src='./img/icon_delete.gif' class='imgCarpetasFiles' border='0' /></a>&nbsp;&nbsp;<a href='#' onclick='renombrarDirectorio(\""+valores[2]+"\",\""+txt+"\",\""+idNombre+"\",\""+boton+"\")' title='Renombrar'><img src='./img/duplicate.png' class='imgCarpetasFiles' border='0' /></a></div>";
		      listadoDirectoriosActual.push(valores[2]);
            }else{
		cssImagen="imagenFileArchivo";
                nombreFuncion="<div class='contenedorFile' onclick='mostrarArchivo(\""+path+"\")'>";
                funcionEliminar="<div id='"+divOpciones+"' class='checkFile'><input type='checkbox' value='"+valores[2]+"' name='chkFiles' id='"+chk+"' style='margin-left: 3px;' onclick='seleccionarCheck(this.id)' /><a href='#' onclick='eliminarArchivo(\""+valores[2]+"\")' title='Eliminar'><img src='./img/icon_delete.gif' class='imgCarpetasFiles' border='0' /></a>&nbsp;&nbsp;<a href='#' onclick='renombrarDirectorio(\""+valores[2]+"\",\""+txt+"\",\""+idNombre+"\",\""+boton+"\")'  title='Renombrar'><img src='./img/duplicate.png' class='imgCarpetasFiles' border='0' /></a></div>";
            }
            //funcionRenombrar="<div id='"+idNombre+"' class='nombreFileDir'>"+valores[2]+"</div><div id='"+div+"'><input type='text' name='"+txt+"' id='"+txt+"' value='"+valores[2]+"' style='display:none;' /></div>";
	    //<input name="" id="" type="checkbox" onClick="if(this.checked == true){totalizar(<?=$row1['unicantidad'];?>)} else{restarTotal(<?=$row1['unicantidad'];?>)}"
            if (valores[2].length > 16) {
		      nombreFileDir=valores[2].substring(0,13)+"...";
	        }else{
		      nombreFileDir=valores[2];
	        }
	    
            //se arman las estructuras para los diferentes elementos del directorio
            elemento="<div class='contenedorArchivo'>";
            elemento+="<div class='limiteCarpeta'>";
            elemento+=funcionEliminar;
            elemento+=nombreFuncion;
            elemento+="<div class='"+cssImagen+"'></div>";
            elemento+="</div>";
            elemento+="</div>";
            elemento+="<div class='nombreFileDir'><span id='"+idNombre+"' title='"+valores[2]+"'>"+nombreFileDir+"</span></div><div id='"+div+"'><input type='text' name='"+txt+"' id='"+txt+"' value='"+valores[2]+"' style='display:none;' /><input type='button' id='"+boton+"' value='Guardar...' onclick='guardarNuevoNombreDir(\""+valores[2]+"\",\""+txt+"\",\""+idNombre+"\",\""+evento+"\")' style='display:none;' /></div>";
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
        //alert("Directorio creado");
        pathActual=$("#hdnRutaActual").val();
	actualizarDirectorio(pathActual);
    }else if(accion=="crearDir" && datos=="0"){//error al crear el directorio
        alert("Error, al crear el directorio indicado");
    }else if(accion=="crearDir" && datos=="11"){
        alert("La carpeta ya existe en el directorio");
    }
    
}
function retrocederDirectorio(){
    rutaActual=$("#hdnRutaActual").val();    
    //ajaxApp("browserArchivos","auxVisor.php","action=retrocederDirectorio&raizDirectorio="+raizDirectorio+"&rutaActual="+rutaActual,"POST");
    ajaxAppExplorador("retrocederDirectorio","controlador.php","action=retrocederDirectorio&raizDirectorio="+raizDirectorio+"&rutaActual="+rutaActual,"POST");
}

function seleccionarCheck(idElemento,elemento){
    $( "#"+idElemento ).removeClass( "contenedorArchivo" ).addClass( "contenedorArchivoSeleccionado" );
    contenidoM.push(elemento);
    $("#browserArchivos").css("width","60%");//se cambia de tamaño el div de los archivos
    $("#propiedades").show();
    $("#propiedades").css("width","39%");
    $("#txtPropiedades").html("&raquo;Mover elementos seleccionados");
    $("#subirArchivos2").html("");
    var comboMover="<div style='height:130px;padding:5px;border:1px solid #CCC;'><span class='clase14'>Que desea hacer?</span><br /><br />";
    comboMover+="&nbsp;Acci&oacute;n:&nbsp;<select name='cboAccion' id='cboAccion'><option value='...' selected='selected'>Seleccionar ...</option><option value='copiar'>Copiar</option><option value='mover'>Mover</option></select><br />";
    comboMover+="<br />&nbsp;Seleccionar destino:&nbsp;";
    comboMover+="<select name='cboFiltroMover' id='cboFiltroMover'><option value='...' selected='selected'>Seleccionar ...</option>";
    for(var j=0;j<listadoDirectoriosActual.length;j++){
	comboMover+="<option value='"+listadoDirectoriosActual[j]+"'>"+listadoDirectoriosActual[j]+"</option>";
    }
    comboMover+="</select>&nbsp;&nbsp;&nbsp;<input type='button' value='Mover...' onclick='moverArchivos()' /><br /><br />Archivos seleccionados:<br /></div>";
    
    $("#subirArchivos2").append(comboMover);
    for(var i=0;i<contenidoM.length;i++){
	divMover="divMover_"+contenidoM[i];
	$("#subirArchivos2").append("<div id='"+divMover+"' class='elementosSeleccionados'>"+contenidoM[i]+"</div>");
    }
}
function quitarSeleccionCheck(idElemento,elemento){
    console.log(idElemento);
    console.log(contenidoM);
    idABorrar = contenidoM.indexOf(elemento.toString());
    console.log(idABorrar);
    if(idABorrar != -1){//se borra el elemento del array
	contenidoM.splice(idABorrar, 1);//se quita el elemento del array
	//se localiza el div y se borra de los elementos a mover
	divABorrar="divMover_"+elemento;
	console.log(divABorrar);
	if($("#"+divABorrar).length){
	    $("#"+divABorrar).remove();
	}
	console.log(contenidoM);
    }
}
function listarDirectoriosMover() {
    //listar los directorios donde se puede mover el contenido
    
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
    //se revisa si el arreglo de los directorios seleccionados contiene datos
    if (contenidoM.length > 0) {
	contenidoM=[];
	cerrarVentanaSubirArchivos();
    }
    
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
    $("#browserArchivos").css("width","60%");
    $("#propiedades").show();
    $("#propiedades").css("width","39%");
    $("#txtPropiedades").html("&raquo;Subir archivos...");
    rutaActual=$("#hdnRutaActual").val();
    //$("#subirArchivos").show();
    //ajaxApp("detalleSubirArchivos","auxVisor.php","action=mostrarFormArchivos&rutaActual="+rutaActual,"POST");
    ajaxAppExplorador("subirArchivos","controlador.php","action=mostrarFormArchivos&rutaActual="+rutaActual,"POST")
    
}
function cerrarVentanaSubirArchivos(){
    rutaActual=$("#hdnRutaActual").val();
    //$("#subirArchivos").hide();
    $("#propiedades").hide();
    $("#browserArchivos").css("width","99.2%");
    actualizarDirectorio(rutaActual);
    finEditarContenido();
}
function moverArchivos(){
    //se recupera el contenido del combo que contiene el filtro
    accionARealizar=$("#cboAccion").val();
    directorioDestino=$("#cboFiltroMover").val();
    pathActual=$("#hdnRutaActual").val();
    if (directorioDestino=="..." || directorioDestino==null || directorioDestino==undefined || accionARealizar=="..." || accionARealizar==null || accionARealizar==undefined) {
	alert("Seleccione la Accion a realizar y despues elija el directorio destino.");
    }else{
	archivosA="";
	$("#subirArchivos2 .elementosSeleccionados").each(function (index) {
	    id=this.id;
	    //console.log(id.substring(9));
	    if(archivosA==""){
		archivosA=id.substring(9);
	    }else{
		archivosA+=","+id.substring(9);
	    }
	});
	destino=pathActual+"/"+directorioDestino;
	//archivosB=archivosA;
	console.log(destino);
	console.log(archivosA);
	ajaxAppExplorador("accionesArchivos","controlador.php","action=accionesArchivos&operacion="+accionARealizar+"&destino="+destino+"&archivosA="+archivosA+"&rutaActual="+pathActual,"POST");
    }
}