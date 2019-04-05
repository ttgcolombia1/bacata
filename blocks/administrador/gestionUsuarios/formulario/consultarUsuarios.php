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

        echo "<div ><table id='tablaUsuarios'  width='96%' >";

        echo "<thead>
                <tr align='center'>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Tipo Usuario</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Cambio estado</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>";

        for($i=0;$i<count($resultadoUsuarios);$i++)
        {
            $variable = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro
            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variable.= "&id_usuario=" .$resultadoUsuarios[$i][0];
            
            $variableEditar = $variable; 
            $variableEditar.= "&opcion=editar";
            $variableEditar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableEditar, $directorio);

            $variableInhabilitar = $variable;
            $variableInhabilitar.= "&opcion=inhabilitar";
            if($resultadoUsuarios[$i][7]==0)
                { $variableInhabilitar.= "&estado=1";
                  $imagen = "player_pause.png";
                }
            else{ $variableInhabilitar.= "&estado=0";
                  $imagen = "continuar.png";  
                }
            $variableInhabilitar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableInhabilitar, $directorio);

            $variableborrar = $variable;
            $variableborrar.= "&opcion=borrar";
            $variableborrar= $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableborrar, $directorio);
            
            if($resultadoUsuarios[$i][7]==0)
                {$estado='Inactivo';}
            elseif($resultadoUsuarios[$i][7]==1)
                {$estado='Activo';}
            elseif($resultadoUsuarios[$i][7]==2)
                {$estado='Nuevo';}    
            
            $mostrarHtml = "<tr align='center'>
                    <td width='10%' >".$resultadoUsuarios[$i][0]."</td>
                    <td width='15%' >".$resultadoUsuarios[$i][1]."</td>
                    <td width='15%'>".$resultadoUsuarios[$i][2]."</td>
                    <td>".$resultadoUsuarios[$i][3]."</td>
                    <td>".$resultadoUsuarios[$i][4]."</td>
                    <td>".$resultadoUsuarios[$i][6]."</td>
                    <td>".$estado."</td>";
                    $mostrarHtml .= "<td width='5%' >";
                    $mostrarHtml .= "<a href='".$variableEditar."'>
                                        <img src='".$rutaBloque."/images/edit.png' width='22px'></a>";
                    $mostrarHtml .= "<td width='5%' >";
                    $mostrarHtml .= "<a href='".$variableInhabilitar."'>
                                        <img src='".$rutaBloque."/images/".$imagen."' width='22px'></a>";
                    $mostrarHtml .= "</td>";
                    $mostrarHtml .= "<td width='5%' >";
                    
                    $mostrarHtml .= "<a href='".$variableborrar."'>
                                        <img src='".$rutaBloque."/images/trash.png' width='22px'></a>";
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
