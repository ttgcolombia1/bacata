<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlHashCodigoFuente extends sql {


	var $miConfigurador;


	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}


	function cadena_sql($tipo,$variable="") {
			
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */

		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
			
		switch($tipo) {

			
                            
			case "dependencias":

				$cadena_sql = "SELECT id_dependencia, nombre ";
                                $cadena_sql .= "FROM ".$prefijo."dependencias ";
                                $cadena_sql .= "ORDER BY id_dependencia";
			break;
                    
			case "tipovotacion":

				$cadena_sql = "SELECT idtipo, descripcion ";
                                $cadena_sql .= "FROM ".$prefijo."tipovotacion ";
                                $cadena_sql .= "ORDER BY idtipo";
			break;
                    
			case "tipoestamento":

				$cadena_sql = "SELECT idtipo, descripcion ";
                                $cadena_sql .= "FROM ".$prefijo."tipoestamento ";
                                $cadena_sql .= "ORDER BY idtipo";
			break;
                    
			case "datosRestricciones":

				$cadena_sql = "SELECT idtipo, descripcion, nombre_campo ";
                                $cadena_sql .= "FROM ".$prefijo."tiporestriccion ";
                                $cadena_sql .= "ORDER BY idtipo";
			break;
                    
                        case "actoadministrativo":

				$cadena_sql = "SELECT idacto, descripcion ";
                                $cadena_sql .= "FROM ".$prefijo."actoadministrativo ";
                                $cadena_sql .= "ORDER BY idacto";
			break;
                    
                        case "idioma":

				$cadena_sql = "SET lc_time_names = 'es_ES' ";
			break;
                    
                        case "consultarProcesosActivos":
                            
				$cadena_sql = "SELECT DISTINCT nombre, ".$prefijo."procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, ".$prefijo."tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
				$cadena_sql .= "CONCAT(".$prefijo."actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                                $cadena_sql .= ",idprocesoelectoral ";
                                $cadena_sql .= "FROM ".$prefijo."procesoelectoral ";
                                $cadena_sql .= "JOIN ".$prefijo."actoadministrativo ON ".$prefijo."procesoelectoral.tipoactoadministrativo = ".$prefijo."actoadministrativo.idacto  ";
                                $cadena_sql .= "JOIN ".$prefijo."tipovotacion ON ".$prefijo."procesoelectoral.tipovotacion = ".$prefijo."tipovotacion.idtipo  ";
                                $cadena_sql .= " WHERE  1=1 ";
                                if($variable[0] != '')
                                    {
                                        $cadena_sql .= " AND fechainicio > '".$variable."' ";
                                    }
                                
			break;
                        
                        case "datosProceso":
                            
				$cadena_sql = "SELECT DISTINCT nombre, ".$prefijo."procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, ".$prefijo."tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
				$cadena_sql .= "CONCAT(".$prefijo."actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                                $cadena_sql .= ",idprocesoelectoral, dependenciasresponsables ";
                                $cadena_sql .= "FROM ".$prefijo."procesoelectoral ";
                                $cadena_sql .= "JOIN ".$prefijo."actoadministrativo ON ".$prefijo."procesoelectoral.tipoactoadministrativo = ".$prefijo."actoadministrativo.idacto  ";
                                $cadena_sql .= "JOIN ".$prefijo."tipovotacion ON ".$prefijo."procesoelectoral.tipovotacion = ".$prefijo."tipovotacion.idtipo  ";
                                $cadena_sql .= " WHERE  idprocesoelectoral= ".$variable;
                                
			break;
                    
                        case "insertarDatoCenso":
                                                        
				$cadena_sql = "INSERT INTO ".$prefijo."censo(identificacion, clave, ideleccion, nombre, idtipo) VALUES (  ";
				$cadena_sql .= " ".$variable[0].", ";
                                $cadena_sql .= " '".$variable[1]."', ";
                                $cadena_sql .= " ".$variable[2].", ";
                                $cadena_sql .= " '".$variable[3]."', ";
                                $cadena_sql .= " ".$variable[4].") ";
                                
			break;
                                                           
                        case "validarDatoCenso":
                            
				$cadena_sql = "SELECT identificacion, clave, ideleccion, nombre, idtipo ";
                                $cadena_sql .= " FROM ".$prefijo."censo ";
				$cadena_sql .= " WHERE identificacion = ".$variable[0];
				$cadena_sql .= " AND ideleccion = ".$variable[2];
                                
			break;
                    
                        case "consultaEleccion":
                            
				$cadena_sql = "SELECT ideleccion, nombre, tipoestamento, descripcion, fechainicio, fechafin, ";
                                $cadena_sql .= " restricciones, tipovotacion, estado, candidatostarjeton, utilizarsegundaclave, eleccionform ";
                                $cadena_sql .= " FROM ".$prefijo."eleccion ";
				$cadena_sql .= " WHERE procesoelectoral_idprocesoelectoral = ".$variable[0];
				$cadena_sql .= " AND eleccionform = ".$variable[1];
                                
			break;
                    
                        case "consultaCandidatos":
				$cadena_sql = "SELECT listas.nombre, posiciontarjeton, identificacion, candidatos.nombre, apellido ";
                                $cadena_sql .= " FROM ".$prefijo."lista listas  ";
                                $cadena_sql .= " JOIN ".$prefijo."candidato candidatos ON listas.idlista = candidatos.lista_idlista  ";
				$cadena_sql .= " WHERE eleccion_ideleccion = ".$variable[1];
				$cadena_sql .= " order by candidatos.idcandidato ";
                                
			break;
				/**
				 * Clausulas genéricas. se espera que estén en todos los formularios
				 * que utilicen esta plantilla
				 */

			case "iniciarTransaccion":
				$cadena_sql="START TRANSACTION";
				break;

			case "finalizarTransaccion":
				$cadena_sql="COMMIT";
				break;

			case "cancelarTransaccion":
				$cadena_sql="ROLLBACK";
				break;


			case "eliminarTemp":

				$cadena_sql="DELETE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion = '".$variable."' ";
				break;

			case "insertarTemp":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="( ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";

				foreach($_REQUEST as $clave => $valor) {
					$cadena_sql.="( ";
					$cadena_sql.="'".$idSesion."', ";
					$cadena_sql.="'".$variable['formulario']."', ";
					$cadena_sql.="'".$clave."', ";
					$cadena_sql.="'".$valor."', ";
					$cadena_sql.="'".$variable['fecha']."' ";
					$cadena_sql.="),";
				}

				$cadena_sql=substr($cadena_sql,0,(strlen($cadena_sql)-1));
				break;

			case "rescatarTemp":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion='".$idSesion."'";
				break;



		}
		return $cadena_sql;

	}
}
?>
