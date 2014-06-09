<?php
    /**
     *@name		Pantalla principal del explorador
     *@fecha		Septiembre 2013
     *@version		1.0.0
     *@author		Gerardo Lara <gerardolara1984@gmail.com>
     */
    //session_start();
    //se incluye el archivo de configuracion
    include "config.php";
    $rutaExplorar=$config['explorador']['path'];
    /*if($_SERVER["HTTP_REFERER"]==""){
        echo "Acceso incorrecto";
        exit;
    }else{
        if(!isset($_SESSION["usuario_nivel"])){
            echo "Ingrese de nuevo al Sistema";
            exit;
        }
    }*/
?>
<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script language="javascript">
    raizDirectorio="<?=$rutaExplorar;?>";
    $(document).ready(function (){
	redimensionarPag();
        abrirDirectorio('<?=$rutaExplorar;?>','browserArchivos');
	$('#btnAtras').hide();
    });
    
    function redimensionarPag(){
            var altoDiv=$("#contenedorNavegadorArchivos").height();
            var anchoDiv=$("#contenedorNavegadorArchivos").width();		
            var altoCuerpo=altoDiv-75;
            var anchoCuerpo=anchoDiv-13;
            $("#browserArchivos").css("height",altoCuerpo+"px");            	
            $("#browserArchivos").css("width",(anchoCuerpo)+"px");
	    $("#vistaPreviaArchivo").css("height",altoCuerpo+"px");            	
            $("#vistaPreviaArchivo").css("width",(anchoCuerpo)+"px");
	    $("#propiedades").css("height",altoCuerpo+"px");
    }
    
    window.onresize=redimensionarPag;
    
    function cerrarVistaPrevia(){
	pathActual=$("#hdnRutaActual").val();//se recupera la ruta actual	
	actualizarDirectorio(pathActual);
    }

    
        
    function mostrarArchivo(path){        
	$("#browserArchivos").hide();
	$("#vistaPreviaArchivo").show();
	$("#vistaPreviaArchivo").attr("src",path);
	$("#btnVistaPrevia").show();
    }
    
    /*function ajaxApp(divDestino,url,parametros,metodo){	
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#cargadorAcciones").show().html("<p>Cargando...</p>"); 
	},
	success:function(datos){	
		$("#cargadorAcciones").hide();
		$("#"+divDestino).show().html(datos);
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
    }*/
    
    
    function ocultarVistaPrevia(){
	$("#browserArchivos").show();
	$("#vistaPreviaArchivo").hide();
	$("#btnVistaPrevia").hide();
    }
</script>
<input type="hidden" name="hdnRutaActual" id="hdnRutaActual" value="" />
<input type="hidden" name="hdnCantElementos" id="hdnCantElementos" value="" />
<div id="cargadorAcciones">Aplicando cambios...</div>
<div id="contenedorNavegadorArchivos" style="width: 99.5%;height: 98.5%;border: 1px solid #666;background: #FFF;margin: 2px;position:absolute;">
    <div id="barraNavegacion" style="width: 99.2%;height: 26px; border: 1px solid #666;background: #FFF;margin: 5px 5px 1px 5px;">
        <div style="float: left;width:80px;background: #e1e1e1;height: 15px;padding: 5px;margin: 0;padding: 5px;font-weight: bold;">Explorando:</div>
        <div id="ubicacionDirectorios" style="float: left;width:auto;background: #fff;height: 15px;padding: 5px;margin: 0;padding: 5px;font-size: 10px;"></div>
    </div>
    <div id="barraBotones" style="width: 98.8%;height: 26px; border: 1px solid #666;background: #F0F0F0;margin: 0px 5px 2px 5px;padding: 2px;">
        <div id="btnAtras" class="estiloAtras" onclick="retrocederDirectorio()">&laquo;&laquo;Atras</div>
<?
    //if($_SESSION["usuario_nivel"]==0 || $_SESSION["usuario_nivel"]==1){
?>
        <div class="estiloNuevaCarpeta" onclick="crearDirectorio()">Nueva Carpeta</div>
	<div class="estiloSubirArchivo" onclick="mostrarFormSubirArchivos()">Subir Archivos</div>
	<div id="btnEditar1" class="estiloEditar" onclick="editarContenido()">Editar</div>
        <div id="btnEditar2" class="estiloEditarActivo" onclick="finEditarContenido()">Fin Edicion</div>
<?
    //}
?>
	<div id="btnVistaPrevia" class="estiloCerrarVistaPrevia" style="width: auto;" onclick="cerrarVistaPrevia()">Cerrar Vista Previa</div>
    </div>
    <div id="browserArchivos" style="margin: 0px 5px 5px 5px;width: 99.2%;border: 1px solid #CCC;background: #FFF;position: relative;overflow-x: auto;float: left;">
	
    </div>
    <div id="propiedades" style="display: none;position: absolute;width: 28.5%;height: 300px;top: 68px;background: #F0F0F0;border: 1px solid #CCC;right: 5px;float: right;">
	<div id="txtPropiedades" style="background: #FFF;height: 15px;padding: 5px;text-align: left;color: #666;font-weight: bold;"></div>
	<div id="subirArchivos2" style="border: 1px solid #CCC;background: #FFF;width: 96.5%;height: 85%;margin: 5px;">
	    
	</div>
	<div style="border: 1px solid #ccc;background: #fff;width: 94.5%;height: 26px;padding: 5px;margin: 5px;text-align: right;"><input type="button" value="Cerrar Ventana" onclick="cerrarVentanaSubirArchivos()" style="background: #ff0000;color: #FFF;height: 25px;padding: 5px;"></div>
    </div>
    <iframe id="vistaPreviaArchivo" style="display: none;margin: 0px 5px 5px 5px;width: 99.2%;border: 1px solid #CCC;background: #F0F0F0;position: relative;overflow-x: auto;"></iframe>
</div>
<div id="subirArchivos" style="display: none;background: url(img/desv.png) repeat;position: absolute;width: 100%;height: 100%;">
    <div style="width: 500px;height: 400px;position: absolute;left: 50%;top: 50%;margin-left: -250px;margin-top: -200px;border: 1px solid #CCC;z-index: 10;background: #fff;">
        <div style="height: 17px;padding: 7px;border: 1px solid #CCC;width: 485px;background: #F0F0F0;color: #666;font-weight: bold;">Subir archivos...</div>
        <div id="detalleSubirArchivos" style="border: 1px solid #CCC;width: 498px;height: 330px; overflow:hidden;"></div>
        <div style="border: 1px solid #ccc;background: #f0f0f0;width: 488px;height: 25px;padding: 5px;text-align: right;"><input type="button" value="Cerrar Ventana" onclick="cerrarVentanaSubirArchivos()"></div>
    </div>
</div>
