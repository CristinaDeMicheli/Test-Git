<?php
class nuevo_libro extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//------------

	function get_datos_reportes_libros($where = '')
	{
		$sql = "SELECT	t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_l.estante,
		t_es.descripcion as id_estado_nombre,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_l.anio,
		t_g.descripcion as id_genero_nombre,
		t_l.isbn,
		t_l.foto
		FROM
		curlib.libro as t_l LEFT OUTER JOIN cidig.estado as t_es ON (t_l.id_estado = t_es.id_estado),
		curlib.autor as t_a,
		curlib.editorial as t_e,
		curlib.adquisicion as t_ad,
		curlib.genero as t_g
		WHERE 
			t_l.id_autor = t_a.id_autor 
			AND t_l.id_editorial = t_e.id_editorial 
			AND t_l.adquicision_id = t_ad.id_adquisicion 
			AND t_l.id_genero = t_g.id_genero 
			AND $where			
	ORDER BY titulo";
		return toba::db()->consultar($sql);
	}


	function conf__cuadro(leanInicial_ei_cuadro $cuadro)
	{
		if (isset($this->s__filtro)) {
			$filtro = $this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_datos_reportes_libros($filtro));
		} else {
			$cuadro->desactivar_modo_clave_segura();
			$sql = ("SELECT count(id_libro) as ejemplar,
		t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_es.descripcion id_estado_nombre,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_g.descripcion id_genero_nombre,
		t_l.anio,
		t_l.estante,
		t_l.foto
		from curlib.libro as t_l
		INNER JOIN curlib.autor as t_a on (t_l.id_autor = t_a.id_autor)
		INNER JOIN curlib.editorial as t_e on (t_l.id_editorial = t_e.id_editorial)
		INNER JOIN curlib.estado as t_es on (t_l.id_estado = t_es.id_estado)
		INNER JOIN curlib.adquisicion as t_ad on (t_l.adquicision_id = t_ad.id_adquisicion)
		INNER JOIN curlib.genero as t_g on (t_l.id_genero = t_g.id_genero)
		group by t_l.id_libro, t_l.id_libro, t_l.titulo, t_l.resumen, t_a.nombre, t_e.nombre, t_es.descripcion, 
		t_ad.descripcion, t_g.descripcion, t_l.anio, t_l.estante, t_l.foto");
			$datos = toba::db()->consultar($sql);
			/* $img_pendiente = toba_recurso::imagen_proyecto('img/imagenes/', true);
		$datos=  $img_pendiente; */
			//$datos[0]['imghtml'] = $img_pendiente;
			$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->rel()->cargar($datos);
		$this->rel()->tabla('libro')->set_cursor(0);
		$nombre_img = toba::db()->consultar("SELECT foto FROM curlib.libro where id_libro= '$datos[id_libro]'");
		$this->s__nom_img = $nombre_img;

		$this->set_pantalla('pant_edicion');
	}

	function conf_evt__cuadro__seleccion(toba_evento_usuario $evento, $fila)
	{
	}

}
?>