<?php
class reporte_persona extends leanInicial_ci
{
	protected $s__persona;
	protected $s__id_persona;
	//-----------------------------------------------------------------------------------
	//---- reporte_persona --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function rel(){
		return $this->dep('datos');
	}
	function conf__reporte_persona(leanInicial_ei_cuadro $cuadro)
	{
		$filtro = null;
		if (isset($this->s__persona)) {
			$filtro = $this->dep('filtro_reporte_persona')->get_sql_where();
		}
		$datos = toba::consulta_php('consultas')->get_persona($filtro);
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_reporte_persona -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_reporte_persona(leanInicial_ei_filtro $filtro)
	{
		if (isset($this->s__persona)) {
			$filtro->set_datos($this->s__persona);
		}
	}

	function evt__filtro_reporte_persona__filtrar($datos)
	{
		$this->s__persona = $datos;
	}

	function evt__filtro_reporte_persona__cancelar()
	{
		unset($this->s__persona);
	}

	function evt__reporte_persona__seleccion($seleccion)
	{
		$this->s__id_persona = $seleccion['id_persona'];
		$this->set_pantalla('ver_listado');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_ver_listado -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_ver_listado(leanInicial_ei_cuadro $cuadro)
	{
		$id = intval($this->s__id_persona);
		$datos = toba::consulta_php('consultas')->ver_prestamos_por_persona($id);
		/*var_dump($datos);
		exit();*/
		$cuadro->set_datos($datos);
	}

}
?>