<?php

//Evitar un acceso directo a este archivo
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}
$cadena_sql = $this->sql->cadena_sql("buscarContadores");
$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if ($registro) {

	$registro['tipo']='contadores';
	 //-------------------------------Mensaje-------------------------------------
	$esteCampo = "totalVotos";
	$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = "information";
	$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo, $registro);
	echo $this->miFormulario->cuadroMensaje($atributos);
	
}

?>