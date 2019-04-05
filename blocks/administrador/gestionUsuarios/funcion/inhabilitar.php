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
	$parametro=array('usuario'=>$_REQUEST['id_usuario'],'estado'=>$_REQUEST['estado']);
        $this->cadena_sql = $this->sql->cadena_sql("inhabilitarUsuario", $parametro);
        $resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $this->funcion->redireccionar('inhabilito',$_REQUEST['id_usuario']);
	}else
	{
		$this->funcion->redireccionar('noInhabilito',$_REQUEST['id_usuario']);
	}



}