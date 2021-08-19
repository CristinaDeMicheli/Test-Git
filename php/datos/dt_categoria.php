<?php
class dt_categoria extends leanInicial_datos_tabla
{
	function get_categoria()
	{
		$sql = "SELECT id_categoria, descripcion FROM categoria ORDER BY categoria";
		return toba::db('leanInicial')->consultar($sql);
	}


}
?>