<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
// -------------Campo Imagen-----------------------
$esteCampo = 'imagen';
$atributos ["id"] = $esteCampo;
$atributos ['ancho'] = '400px';
$atributos ['alto'] = '';
$atributos ['estilo'] = 'campoImagen textoDerecha ';
//$atributos ['estiloImagen'] = '';
$atributos ['imagen'] = $directorio.'/imagen/logoBacata.png';

echo $this->miFormulario->campoImagen( $atributos );
unset ( $atributos );
