<?php
class dt_libro extends leanInicial_datos_tabla
{
	function get_listado()
	{
		$sql = ('SELECT t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_g.descripcion as id_genero_descripcion,
		t_l.estante,
		t_l.anio,
		t_l.isbn,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_es.descripcion as id_estado_nombre
		FROM
		curlib.libro as t_l LEFT OUTER JOIN curlib.estado as t_es ON (t_l.id_estado = t_es.id_estado),
		curlib.autor as t_a,
		curlib.editorial as t_e,
		curlib.adquisicion as t_ad, 
		curlib.genero as t_g 
		WHERE 
			t_l.id_autor = t_a.id_autor 
			AND t_l.id_editorial = t_e.id_editorial  
			AND t_l.id_estado = t_es.id_estado
			AND t_l.adquicision_id = t_ad.id_adquisicion
			AND t_l.id_genero = t_g.id_genero
	ORDER BY titulo');
		return toba::db()->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id_libro, titulo FROM libro ORDER BY titulo";
		return toba::db('leanInicial')->consultar($sql);
	}

}
?>