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
</script>
<input type="hidden" name="hdnRutaActual" id="hdnRutaActual" value="" />
<input type="hidden" name="hdnCantElementos" id="hdnCantElementos" value="" />
<div id="cargadorAcciones">Aplicando cambios...</div>
<div id="contenedorNavegadorArchivos">
    <div id="barraNavegacion">
        <div class="tituloRutaExplorar">Explorando:</div>
        <div id="ubicacionDirectorios"></div>
    </div>
    <div id="barraBotones">
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
	<div id="btnVistaPrevia" class="estiloCerrarVistaPrevia" onclick="cerrarVistaPrevia()">Cerrar Vista Previa</div>
    </div>
    <div id="browserArchivos"></div>
    <div id="propiedades">
	<div id="txtPropiedades"></div>
	<div id="subirArchivos2">
	    
	</div>
	<div id="divBtnCerrar"><input type="button" id="btnCerrarVentana" value="Cerrar Ventana" onclick="cerrarVentanaSubirArchivos()"></div>
    </div>
    <iframe id="vistaPreviaArchivo"></iframe>
</div>
<div id="subirArchivos" style="">
    <div class="divContenedorVentanaSubir">
        <div class="tituloSubirArchivos">Subir archivos...</div>
        <div id="detalleSubirArchivos"></div>
        <div style="border: 1px solid #ccc;background: #f0f0f0;width: 488px;height: 25px;padding: 5px;text-align: right;"><input type="button" value="Cerrar Ventana" onclick="cerrarVentanaSubirArchivos()"></div>
    </div>
</div>
