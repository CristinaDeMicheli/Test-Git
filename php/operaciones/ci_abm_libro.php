<?php
class ci_abm_libro extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	//variable de sesion
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
		$this->informar_msg('Datos guardados correctamente!', 'info');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(leanInicial_ei_cuadro $cuadro)
	{
		$filtro = null;
			if (isset($this->s__datos_filtro)){//preguntar si la variable esta seteada (tiene valores)
			$filtro = $this->dep('filtro_libro')->get_sql_where();//dame el objeto que representa el filtro  y pasalo por where
			}
		
		
		$datos = toba::consulta_php('consultas')->get_libro($filtro);
		//seteo el cuadro con la consulsta que traje de la carpeta "consultas"//
		$cuadro->set_datos($datos);
		//tmb se puede utilizar el return en lugar del set_datos pero no se podra realizar mas nada luego de eso
		//return $datos;	

	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__formulario(leanInicial_ei_formulario $form)
	{
		//traigo lo que tengo cargo en el form despues del evento seleccion
		$datos = $this->dep('datos')->get();

		//var_dump($datos); = ei_arbol($datos);
		//ei_arbol($datos);
		//exit();
		$form->set_datos($datos);
	}

	function evt__formulario__modificacion($datos)
	{
		//utilizo para guardar los datos que se van a modificar
		$s__datos['form'] = $datos;
		//modifico los valores
		$this->dep('datos')->set($datos);
		//ei_arbol($datos);
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



	//-----------------------------------------------------------------------------------
	//---- filtro_libro -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__filtro_libro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function conf__filtro_libro(leanInicial_ei_filtro $filtro)
	{
		//PREGUNTO SI TENGO DATOS EN EL FILTRO
		if (isset($this->s__datos_filtro)){
			$filtro->set_datos($this->s__datos_filtro);
		} 
	}

	function evt__filtro_libro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

}
?>