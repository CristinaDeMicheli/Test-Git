<?php
class dt_editorial extends leanInicial_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_editorial, nombre FROM editorial ORDER BY nombre";
		return toba::db('leanInicial')->consultar($sql);
	}


}
?>