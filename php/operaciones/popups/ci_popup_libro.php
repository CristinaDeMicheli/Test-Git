<?php
class ci_popup_libro extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
	}

	function evt__cancelar()
	{
	}

	function evt__eliminar()
	{
	}

	function evt__guardar()
	{
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_popup_libro -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_popup_libro(leanInicial_ei_cuadro $cuadro)
	{
		$cuadro->desactivar_modo_clave_segura();
		$datos = toba::consulta_php('consultas')->get_libro_disponible();
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_popup_libro -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_popup_libro(leanInicial_ei_filtro $filtro)
	{
	}

	function evt__filtro_popup_libro__filtrar($datos)
	{
	}

	function evt__filtro_popup_libro__cancelar()
	{
	}
	//VER PARA QUE CARAJOS ESTA ESTA FUNCION XQ NO HACE NADA
	/*static function get_libro_pp($id = 0){
		$rs = toba::db()->consultar("SELECT 
											id_libro,
											titulo,
											au.nombre as autor,
											ed.nombre as editorial,
											es.descripcion as estado,
											ge.descripcion as genero
										from curlib.libro as t_l
										INNER JOIN curlib.autor as au on t_l.id_autor = au.id_autor
				INNER JOIN curlib.editorial as ed on t_l.id_editorial = ed.id_editorial
				INNER JOIN curlib.estado as es on t_l.id_estado = es.id_estado
				INNER JOIN curlib.genero as ge on t_l.id_genero = ge.id_genero
										WHERE id_libro = ".$id);
		
		$valor = "no se pudo identificar el id del libro: ".$id;
		if(count($rs) > 0){
			$valor = $rs[0]['titulo'];
		}
		return $valor;
	}*/

	static function get_libro_pp($id = 0)
	{
		$rs = toba::db()->consultar("SELECT titulo FROM curlib.libro WHERE id_libro = ".$id);
		$valor = "No se pudo identificar el Id. libro: ".$id;
		if(count($rs) > 0 ){
			$valor = $rs[0]['titulo'];
		}
		return $valor;
	}
	

}
?>