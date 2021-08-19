<?php
class ci_abm_categoria extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

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
	//---- cuadro_categoria -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_categoria(leanInicial_ei_cuadro $cuadro)
	{
		$datos = toba::consulta_php('consultas')->get_categoria();
		$cuadro->set_datos($datos);
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

	function evt__cuadro_categoria__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}


	//-----------------------------------------------------------------------------------
	//---- frm_categoria ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_categoria(leanInicial_ei_formulario $form)
	{
		$datos = $this->dep('datos')->get();
		$form->set_datos($datos);
	}

	function evt__frm_categoria__modificacion($datos)
	{
		$this->dep('datos')->set($datos);
		//ei_arbol($datos);
		$this->set_pantalla('pant_inicial');
	}

}
?>