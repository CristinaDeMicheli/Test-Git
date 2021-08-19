<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class leanInicial_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'leanInicial_ci' => 'extension_toba/componentes/leanInicial_ci.php',
		'leanInicial_cn' => 'extension_toba/componentes/leanInicial_cn.php',
		'leanInicial_datos_relacion' => 'extension_toba/componentes/leanInicial_datos_relacion.php',
		'leanInicial_datos_tabla' => 'extension_toba/componentes/leanInicial_datos_tabla.php',
		'leanInicial_ei_arbol' => 'extension_toba/componentes/leanInicial_ei_arbol.php',
		'leanInicial_ei_archivos' => 'extension_toba/componentes/leanInicial_ei_archivos.php',
		'leanInicial_ei_calendario' => 'extension_toba/componentes/leanInicial_ei_calendario.php',
		'leanInicial_ei_codigo' => 'extension_toba/componentes/leanInicial_ei_codigo.php',
		'leanInicial_ei_cuadro' => 'extension_toba/componentes/leanInicial_ei_cuadro.php',
		'leanInicial_ei_esquema' => 'extension_toba/componentes/leanInicial_ei_esquema.php',
		'leanInicial_ei_filtro' => 'extension_toba/componentes/leanInicial_ei_filtro.php',
		'leanInicial_ei_firma' => 'extension_toba/componentes/leanInicial_ei_firma.php',
		'leanInicial_ei_formulario' => 'extension_toba/componentes/leanInicial_ei_formulario.php',
		'leanInicial_ei_formulario_ml' => 'extension_toba/componentes/leanInicial_ei_formulario_ml.php',
		'leanInicial_ei_grafico' => 'extension_toba/componentes/leanInicial_ei_grafico.php',
		'leanInicial_ei_mapa' => 'extension_toba/componentes/leanInicial_ei_mapa.php',
		'leanInicial_servicio_web' => 'extension_toba/componentes/leanInicial_servicio_web.php',
		'leanInicial_comando' => 'extension_toba/leanInicial_comando.php',
		'leanInicial_modelo' => 'extension_toba/leanInicial_modelo.php',
	);
}
?>