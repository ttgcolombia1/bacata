<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("idioma", "");
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

$cadena_sql = $this->sql->cadena_sql("consultarUsuarios", "");
$resultadoUsuarios = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$variableNuevo = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro
$variableNuevo.= "&opcion=nuevo";
$variableNuevo.= "&usuario=" . $miSesion->getSesionUsuarioId();
$variableNuevo = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableNuevo, $directorio);

echo "<h1>Gestión de Usuarios</h1>";

echo "<div class='boton-nuevo'>
            <a href='".$variableNuevo."'>".$this->lenguaje->getCadena('nuevoUsuario')."</a>
      </div>";

if($resultadoUsuarios)
{
    //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosResultadoParametrizar";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        //echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
        unset($atributos);

        echo "<div ><table id='tablaProcesos'  width='96%' >";

        echo "<thead>
                <tr align='center'>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Tipo Usuario</th>
                    <th>Editar</th>
                    <th>Inhabilitar</th>
                </tr>
            </thead>
            <tbody>";

        for($i=0;$i<count($resultadoUsuarios);$i++)
        {
            $variableEditar = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro
            $variableEditar.= "&opcion=editar";
            $variableEditar.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variableEditar.= "&id_usuario=" .$resultadoUsuarios[$i][0];
            $variableEditar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableEditar, $directorio);

            $variableInhabilitar = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro
            $variableInhabilitar.= "&opcion=inhabilitar";
            $variableInhabilitar.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variableInhabilitar.= "&id_usuario=" .$resultadoUsuarios[$i][0];
            $variableInhabilitar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableInhabilitar, $directorio);

            $mostrarHtml = "<tr align='center'>
                    <td width='8%' >".$resultadoUsuarios[$i][0]."</td>
                    <td width='15%' >".$resultadoUsuarios[$i][1]."</td>
                    <td width='15%'>".$resultadoUsuarios[$i][2]."</td>
                    <td>".$resultadoUsuarios[$i][3]."</td>
                    <td>".$resultadoUsuarios[$i][4]."</td>
                    <td>".$resultadoUsuarios[$i][6]."</td>";
                    $mostrarHtml .= "<td width='5%' >";

                    $mostrarHtml .= "<a href='".$variableEditar."'>
                                        <img src='".$rutaBloque."/images/edit.png' width='25px'>
                                    </a>";
                    $mostrarHtml .= "<td width='5%' >";
                    $mostrarHtml .= "<a href='".$variableInhabilitar."'>
                                        <img src='".$rutaBloque."/images/cancel.png' width='25px'>
                                    </a>";
                    $mostrarHtml .= "</td>";


                $mostrarHtml .= "</tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
        }

        echo "</tbody>";

        echo "</table></div>";

        //Fin de Conjunto de Controles
        //echo $this->miFormulario->marcoAgrupacion("fin");

}else
{
        $nombreFormulario=$esteBloque["nombre"];
                include_once("core/crypto/Encriptador.class.php");
        $cripto=Encriptador::singleton();
        $directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

        $miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

        $tab=1;
        //---------------Inicio Formulario (<form>)--------------------------------
        $atributos["id"]=$nombreFormulario;
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$nombreFormulario;
        $verificarFormulario="1";
        echo $this->miFormulario->formulario("inicio",$atributos);

	$atributos["id"]="divNoEncontroUsuario";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none";
	echo $this->miFormulario->division("inicio",$atributos);

	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroUsuario";
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'information';
	$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
	echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos);

        $valorCodificado="pagina=".$miPaginaActual;
        $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
        $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
        $valorCodificado=$cripto->codificar($valorCodificado);
	//-------------Fin Control Boton----------------------

	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");



	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");

	//-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="formSaraData"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$valorCodificado;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);

        //Fin del Formulario
        echo $this->miFormulario->formulario("fin");
}



?>
