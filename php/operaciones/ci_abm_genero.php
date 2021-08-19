<?php
class ci_abm_genero extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	protected $s__datos_filtro;
	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->evt__cancelar();
		$this->informar_msg('Datos actualizados correctamente!', 'info');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_genero ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_genero(leanInicial_ei_cuadro $cuadro)
	{
		$filtro = null;
		if (isset($this->s__datos_filtro)) {
			$filtro = $this->dep('filtro_genero')->get_sql_where();

		}
		/*var_dump($filtro);*/

		$datos = toba::consulta_php('consultas')->get_descripciones($filtro);
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_genero__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}



	//-----------------------------------------------------------------------------------
	//---- frm_genero -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_genero(leanInicial_ei_formulario $form)
	{
		$datos = $this->dep('datos')->get();
		//var_dump($datos); = ei_arbol($datos);
		//exit();
		$form->set_datos($datos);
	}

	function evt__frm_genero__modificacion($datos)
	{
		$this->dep('datos')->set($datos);
		//ei_arbol($datos);
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_edicion(toba_ei_pantalla $pantalla)
	{
		if (!$this->dep('datos')->esta_cargada()) {
			$pantalla->eliminar_evento('eliminar');
		}
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_genero ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_genero(leanInicial_ei_filtro $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro_genero__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro_genero__cancelar()
	{
		unset($this->s__datos_filtro);
	}

}
?>