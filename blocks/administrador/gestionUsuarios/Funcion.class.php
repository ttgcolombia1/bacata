<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion

//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionGestionUsuarios
{

	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $miInspectorHTML;
	var $error;
	var $miRecursoDB;
	var $crypto;


	function action()
	{
		//Evitar que se ingrese codigo HTML y PHP en los campos de texto
		//Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);
                //Validar las variables para evitar un tipo  insercion de SQL
                $excluir='opcion';
                
		
			if(isset($_REQUEST["procesarAjax"]))
                            {   $this->procesarAjax();}
                        else if($_REQUEST["opcion"]=="guardarDatos")
                            {   $_REQUEST=$this->miInspectorHTML->limpiarSQL($_REQUEST,$excluir);
                                $this->guardarDatos();}
                        else if($_REQUEST["opcion"]=="guardarDatosEditar")
                            {   $_REQUEST=$this->miInspectorHTML->limpiarSQL($_REQUEST,$excluir);
			    $this->guardarDatosEditar();    }
                        else if($_REQUEST["opcion"]=="inhabilitar")
                            {   $this->inhabilitar(); }
                        else if($_REQUEST["opcion"]=="borrar")
                            {   $this->borrar(); }
                        else if($_REQUEST["opcion"]=="resumen")
                            {   $this->resumen(); }
	}


	function __construct()
	{

		$this->miConfigurador=Configurador::singleton();

		$this->miInspectorHTML=InspectorHTML::singleton();
			
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

		$this->miMensaje=Mensaje::singleton();

		$conexion="aplicativo";
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

		if(!$this->miRecursoDB){

			$this->miConfigurador->fabricaConexiones->setRecursoDB($conexion,"tabla");
			$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		}


	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
		//Incluir las funciones
	}
	
	function verificarCampos(){
		include_once($this->ruta."/funcion/verificarCampos.php");
		if($this->error==true){
			return false;
		}else{
			return true;
		}
	
	
	}
	
	function guardarDatos()
	{
		include_once($this->ruta."/funcion/guardarDatos.php");
	}	
	
	function guardarDatosEditar()
	{
		include_once($this->ruta."/funcion/guardarDatosEditar.php");
	}
        
	function inhabilitar()
	{
		include_once($this->ruta."/funcion/inhabilitar.php");
	}	
        
	function borrar()
	{
		include_once($this->ruta."/funcion/borrar.php");
	}                
	function resumen()
	{
		include_once($this->ruta."/funcion/resumenUsuario.php");
	}	
	
	function procesarAjax(){
		include_once($this->ruta."/funcion/procesarAjax.php");
	}
	
	function redireccionar($opcion, $valor=""){
		include_once($this->ruta."/funcion/redireccionar.php");
	}
	
	/**
	 * Métodos de acceso
	 * @param unknown $a
	 */

	function setSql($a)
	{
		$this->sql=$a;
	}

	function setFuncion($funcion)
	{
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje)
	{
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

}
?>
