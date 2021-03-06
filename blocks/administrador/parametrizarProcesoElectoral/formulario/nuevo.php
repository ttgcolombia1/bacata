<?php
include_once("core/crypto/Encriptador.class.php");

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}



$esteBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario=$esteBloque["nombre"];

$cripto=Encriptador::singleton();
$valorCodificado="action=".$esteBloque["nombre"];
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

//------------------Division para las pestañas-------------------------
$atributos["id"]="tabs";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);

//-------------------- Listado de Pestañas (Como lista No Ordenada) -------------------------------

//$items=array("tabCurso"=>$this->lenguaje->getCadena("tabCurso"), "tabDocente"=>$this->lenguaje->getCadena("tabDocente"));
$items=array("tabProceso"=>$this->lenguaje->getCadena("tabProceso"));
$atributos["id"]="pestana";
$atributos["items"]=$items;
$atributos["estilo"]="jqueryui";
$atributos["pestañas"]="true";
echo $this->miFormulario->listaNoOrdenada($atributos);




//------------------Division para la pestaña 2-------------------------
$atributos["id"]="tabProceso";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
include($this->ruta."formulario/tabs/tabProceso.php");
//-----------------Fin Division para la pestaña 1-------------------------
echo $this->miFormulario->division("fin");
/*
//------------------Division para la pestaña 1-------------------------
$atributos["id"]="tabDocente";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
include($this->ruta."formulario/tabs/tabDocente.php");
//-----------------Fin Division para la pestaña 1-------------------------
echo $this->miFormulario->division("fin");
*/

//------------------Fin Division para las pestañas-------------------------
echo $this->miFormulario->division("fin");


