<?php
class ci_abm_autor extends leanInicial_ci
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
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
		$this->informar_msg('Datos actualizados correctamente!', 'info');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_autor -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_autor(leanInicial_ei_cuadro $cuadro)
	{
		$datos = toba::consulta_php('consultas')->get_autor();
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_autor__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}


	//-----------------------------------------------------------------------------------
	//---- frm_autor --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_autor(leanInicial_ei_formulario $form)
	{
		$datos = $this->dep('datos')->get();
		$form->set_datos($datos);
	}

	function evt__frm_autor__modificacion($datos)
	{
		$this->dep('datos')->set($datos);
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

}
?>