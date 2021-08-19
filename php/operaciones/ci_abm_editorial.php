<?php
class ci_abm_editorial extends leanInicial_ci
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
		$this->informar_msg('Datos guardados correctamente!', 'info');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_editorial(leanInicial_ei_cuadro $cuadro)
	{
		//esto me devuelve un array asociativo//
		$datos = toba::consulta_php('consultas')->get_editorial();
		//seteo el cuadro con la consulsta que traje de la carpeta "consultas"//
		$cuadro->set_datos($datos);
		//tmb se puede utilizar el return en lugar del set_datos pero no se podra realizar mas nada luego de eso
		//return $datos;
	}

	function evt__cuadro_editorial__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_editorial(leanInicial_ei_formulario $form)
	{
		//traigo lo que tengo cargo en el form despues del evento seleccion
		$datos = $this->dep('datos')->get();
		//var_dump($datos); = ei_arbol($datos);
		//exit();
		$form->set_datos($datos);

	}

	function evt__frm_editorial__modificacion($datos)
	{
		//modifico los valores
		$this->dep('datos')->set($datos);
		var_dump($datos);
		exit();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//los conf__ se ejecutan antes de que se muestre la pantalla

	function conf__pant_edicion(toba_ei_pantalla $pantalla)
	{
		//pregunto si hay algo carGado, en caso de que no, me saque el boton eliminar
		if (!$this->dep('datos')->esta_cargada()) {
			$pantalla->eliminar_evento('eliminar');
		}
	}

	

}
?>