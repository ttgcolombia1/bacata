<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
 
	$miSesion = Sesion::singleton();
	
	$usuarioSoporte = $miSesion->getSesionUsuarioId(); 
	
	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
	$parametro=array('usuario'=>$_REQUEST['id_usuario']);
        $this->cadena_sql = $this->sql->cadena_sql("borrarUsuario", $parametro);
        $resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $this->funcion->redireccionar('borro',$_REQUEST['id_usuario']);
	}else
	{
		$this->funcion->redireccionar('noBorro',$_REQUEST['id_usuario']);
	}



}