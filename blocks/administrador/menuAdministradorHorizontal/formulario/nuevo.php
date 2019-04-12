<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

// Definimos todos los enlaces a crear

//Inicio pagina administrador
$enlaceIndiceAdministrador['enlace'] = "pagina=indexAdministrador";
$enlaceIndiceAdministrador['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceIndiceAdministrador['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceIndiceAdministrador['enlace'], $directorio);
$enlaceIndiceAdministrador['nombre'] = "Principal";

//Procesos Electorales

//Primer item no tiene url asociada
$enlaceProcesoElectoral['nombre'] = "Procesos Electorales";

//Crear Proceso electoral
$enlaceCrearProceso['enlace'] = "pagina=procesoElectoral";
$enlaceCrearProceso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCrearProceso['enlace'], $directorio);
$enlaceCrearProceso['nombre'] = "Procesos Electorales";

//Parametrizar Proceso electoral
$enlaceParametrizarProceso['enlace'] = "pagina=parametrizarProcesoElectoral";
$enlaceParametrizarProceso['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceParametrizarProceso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceParametrizarProceso['enlace'], $directorio);
$enlaceParametrizarProceso['nombre'] = "Parametrizar";

//Subir el censo electoral
$enlaceCenso['nombre'] = "Gestión Censo";
$enlaceSubirCenso['enlace'] = "pagina=subirCenso";
$enlaceSubirCenso['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceSubirCenso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceSubirCenso['enlace'], $directorio);
$enlaceSubirCenso['nombre'] = "Gestión Censo Electoral";

//Modificar el censo electoral
$enlaceModificarCenso['enlace'] = "pagina=votoTarjeton";
$enlaceModificarCenso['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceModificarCenso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceModificarCenso['enlace'], $directorio);
$enlaceModificarCenso['nombre'] = "Ver tarjetones";

//Hash Codigo Fuente
$enlaceHash['enlace'] = "pagina=hashCodigoFuente";
$enlaceHash['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceHash['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceHash['enlace'], $directorio);
$enlaceHash['nombre'] = "Validar Código Fuente";

//Gestion de Usuarios
$enlaceGestionUsuarios['enlace'] = "pagina=gestionUsuarios";
$enlaceGestionUsuarios['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceGestionUsuarios['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceGestionUsuarios['enlace'], $directorio);
$enlaceGestionUsuarios['nombre'] = "Administrar Usuarios";

//Cambiar Clave acceso
$enlaceCambiarClave['enlace'] = "pagina=cambiarClaveAdministrador";
$enlaceCambiarClave['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceCambiarClave['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCambiarClave['enlace'], $directorio);
$enlaceCambiarClave['nombre'] = "Cambiar Contraseña";

//Cerrar Sesion
$enlaceCerrarSesion['enlace'] = "pagina=cerrarSesionAdministrador";
$enlaceCerrarSesion['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceCerrarSesion['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCerrarSesion['enlace'], $directorio);
$enlaceCerrarSesion['nombre'] = "Salir";

?>
<nav id="cbp-hrmenu" class="cbp-hrmenu">
    <ul>
       
        <li><a href="#">Inicio</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <ul>
                            <li><a href="<?php echo $enlaceIndiceAdministrador['urlCodificada'];?>"><?php echo $enlaceIndiceAdministrador['nombre']?></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /cbp-hrsub-inner -->
            </div> <!-- /cbp-hrsub -->
        </li>
        <li><a href="#">Administrar</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <ul>
                            <li><a href="<?php echo $enlaceGestionUsuarios['urlCodificada'];?>"> <?php echo $enlaceGestionUsuarios['nombre']?></a></li>
                            <li><a href="<?php echo $enlaceHash['urlCodificada'];?>"><?php echo $enlaceHash['nombre']?></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /cbp-hrsub-inner -->
            </div> <!-- /cbp-hrsub -->
        </li>        
        <li><a href="#">Gestión Procesos</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <ul>
                            <li><a href="<?php echo $enlaceCrearProceso['urlCodificada'];?>"> <?php echo $enlaceCrearProceso['nombre']?></a></li>
                            <li><a href="<?php echo $enlaceSubirCenso['urlCodificada'];?>"><?php echo $enlaceSubirCenso['nombre']?></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /cbp-hrsub-inner -->
            </div> <!-- /cbp-hrsub -->
        </li>        
        <li><a href="#">Mi Sesión</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <!--h4>Usuario: <?php echo $datosUsuario[0]['NOMBRE'] . " " . $datosUsuario[0]['APELLIDO'] ?></h4-->
                        <ul>
                            <li><a href="<?php echo $enlaceCambiarClave['urlCodificada'];?>"><?php echo $enlaceCambiarClave['nombre']?></a></li>
                            <li><a href="<?php echo $enlaceCerrarSesion['urlCodificada'];?>"><?php echo $enlaceCerrarSesion['nombre']?></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /cbp-hrsub-inner -->
            </div> <!-- /cbp-hrsub -->
        </li>
    </ul>
</nav>
