<?php
class ci_ver_prestamo extends leanInicial_ci
{
	protected $s__prestamo;
	//-----------------------------------------------------------------------------------
	//---- cuadro_ver_prestamo ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_ver_prestamo(leanInicial_ei_cuadro $cuadro)
	{
		$filtro = null;
		if (isset($this->s__prestamo)) {
			$filtro = $this->dep('filtro_ver_prestamo')->get_sql_where();
		}

		$datos = toba::consulta_php('consultas')->get_prestamo($filtro);
		//seteo el cuadro con la consulsta que traje de la carpeta "consultas"//
		$cuadro->set_datos($datos);
	}

	function rel(){
		return $this->dep('devolucion');
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_ver_prestamo ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_ver_prestamo(leanInicial_ei_filtro $filtro)
	{
		if (isset($this->s__prestamo)) {
			$filtro->set_datos($this->s__prestamo);
		}
	}

	function evt__filtro_ver_prestamo__filtrar($datos)
	{
		$this->s__prestamo = $datos;
	}

	function evt__filtro_ver_prestamo__cancelar()
	{
		unset($this->s__prestamo);
	}

	function evt__cuadro_ver_prestamo__seleccion($seleccion)
	{
		$this->rel()->cargar($seleccion);
		$this->dep('devolucion')->tabla('prestamo')->set_cursor(0);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- frm_devolucion ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_devolucion(leanInicial_ei_formulario $form)
	{
		$datos = $this->rel()->tabla('prestamo')->get();
		/*$prestamo = toba::consulta_php('consultas')->ver_prestamo_de_persona($datos['id_prestamo']);*/
		/*ver_prestamo_de_persona*/
		$form->set_datos($datos);
	}



	function evt__frm_devolucion__modificacion($datos)
	{
		$fecha = date('d-m-Y');
		$datos['fecha_devolucion'] = $fecha;
		$datos['devolucion'] = 'Si';
		/*var_dump($datos);
		exit();*/
		toba::consulta_php('consultas')->actualizar_estado_si($datos['libro_id']);
		$this->rel()->tabla('prestamo')->set($datos);
		$this->rel()->tabla('prestamo')->sincronizar();
		$this->rel()->tabla('prestamo')->resetear();
		$this->informar_msg('Datos guardados correctamente!', 'info');
		$this->set_pantalla('pant_inicial');
	}

	function evt__frm_devolucion__alta($datos)
	{
		/*var_dump($datos);
		exit();*/


		
		$id_libro_nuevo = $datos['libro_id'];
		$id_p = $datos['persona_id'];
		$pres = $datos['id_prestamo'];
		$id_libro_viejo_int = toba::consulta_php('consultas')->get_id_libro_de_prestamo($pres);
		var_dump($id_libro_viejo_int);
		exit();
		$id_libro_viejo = strval($id_libro_viejo_int[0]['libro_id']);
		/*var_dump($id_libro_nuevo, $id_p, $pres, $id_libro_viejo);
		exit();*/
		if ($id_libro_nuevo != $id_libro_viejo) {
			//actualizar_estado inactiva
			//actualizar_estado_si activa
			toba::consulta_php('consultas')->actualizar_estado($id_libro_nuevo);
			toba::consulta_php('consultas')->actualizar_estado_si($id_libro_viejo);
		}

		$this->rel()->tabla('prestamo')->set($datos);
		$this->rel()->tabla('prestamo')->sincronizar();
		$this->rel()->tabla('prestamo')->resetear();
		$this->informar_msg('Datos guardados correctamente!', 'info');
		$this->set_pantalla('pant_inicial');
	}

}
?>