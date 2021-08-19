<?php
class dt_autor extends leanInicial_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_autor, nombre FROM autor ORDER BY nombre";
		return toba::db('leanInicial')->consultar($sql);
	}


}
?>