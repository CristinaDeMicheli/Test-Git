<?php
class dt_genero extends leanInicial_datos_tabla
{
	function get_genero(){
			$sql = ("SELECT
				id_genero,
				descripcion
				FROM
				curlib.genero 
				ORDER BY descripcion");
				return toba::db('leanInicial')->consultar($sql);
		}
	function get_descripciones()
	{
		$sql = "SELECT id_genero, descripcion FROM curlib.genero ORDER BY descripcion";
		return toba::db('leanInicial')->consultar($sql);
	}

}
?>