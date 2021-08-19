<?php
class dt_estado extends leanInicial_datos_tabla
{
	


	function get_descripciones()
	{
		$sql = "SELECT id_estado, descripcion FROM estado";
		return toba::db('leanInicial')->consultar($sql);
	}

}
?>