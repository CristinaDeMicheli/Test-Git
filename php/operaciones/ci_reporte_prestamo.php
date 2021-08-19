<?php
class ci_reporte_prestamo extends leanInicial_ci
{
	protected $s__reporte;
	//-----------------------------------------------------------------------------------
	//---- cuadro_reporte ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_reporte(leanInicial_ei_cuadro $cuadro)
	{
		$filtro = null;
		if (isset($this->s__reporte)) {
			$filtro = $this->dep('filtro_reporte')->get_sql_where();
		}


		$datos = toba::consulta_php('consultas')->get_prestamo($filtro);
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_reporte ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_reporte(leanInicial_ei_filtro $filtro)
	{
		if (isset($this->s__reporte)) {
			$filtro->set_datos($this->s__reporte);
		}
	}

	function evt__filtro_reporte__filtrar($datos)
	{
		$this->s__reporte = $datos;
	}

	function evt__filtro_reporte__cancelar()
	{
		unset($this->s__reporte);
	}

}
?>