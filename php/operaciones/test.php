<?php
class test extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- test -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function rel(){
		return $this->dep('datos');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_test ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_test(leanInicial_ei_cuadro $cuadro)
	{
		$datos = toba::consulta_php('consultas')->get_prestamo();
		/*var_dump($datos);
		exit();*/
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_test__seleccion($seleccion)
	{
		
		$id_l = toba::consulta_php('consultas')->get_prestamo_id($seleccion['id_prestamo']);
		/*var_dump($id_l[0]['libro_id']);
		exit();*/
		$this->rel()->tabla('libro')->cargar(array('id_libro'=>$id_l[0]['libro_id']));
		$this->rel()->tabla('prestamo')->cargar(array('id_prestamo'=>$seleccion['id_prestamo']));
		/*$this->rel()->tabla('prestamo')->set_cursor(0);*/
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_agregar');
	}

	//-----------------------------------------------------------------------------------
	//---- test_form --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------


	function evt__test_form__modificacion($datos)
	{
		$fechaHoy = date('d-m-Y');
		$datos['fecha_devolucion'] = $fechaHoy;
		$fechaVenc = $datos['fecha_venc'];
		$f1 = new DateTime($fechaHoy);
		$f2 = new DateTime($fechaVenc);

		if ($f1 < $f2) {
			$datos['dias_retraso'] = 0;
		}else{
			$diff = $f1->diff($f2);
			$datos['dias_retraso'] = intval($diff->days);
		}
		
		
		/*ESTO ES DE LA BASE DE DATOS*/
		/*$id_libro_bd = toba::consulta_php('consultas')->get_id_libro_de_prestamo($datos['id_prestamo']); */
		/*ESTO ES DEL FORM*/
		$id_l = intval($datos['libro_id']);
			$datos['devolucion'] = 'Si';
			$datos['dias_retraso'];
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$id_l));
			$fila = $this->rel()->tabla('libro')->get_filas();

			$fila[0]['id_estado'] = 1;
			$this->rel()->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();
			
			$this->rel()->tabla('libro')->set($fila[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();
			$this->informar_msg('actualizado', 'info');
	}

	function conf__test_form(leanInicial_ei_formulario $form)
	{
		$datos = $this->rel()->tabla('prestamo')->get();
		$form->set_datos($datos);
	}

	function evt__test_form__modificar($datos)
	{
		
		$viejo = $id_libro_bd = toba::consulta_php('consultas')->get_id_libro_de_prestamo($datos['id_prestamo']);
		$nuevo = intval($datos['libro_id']);
		/*var_dump($viejo[0]['libro_id'], $nuevo);
		exit();*/

		if ($nuevo !== $viejo[0]['libro_id']) {
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$nuevo));
			$fila_nuevo = $this->rel()->tabla('libro')->get_filas();
			$fila_nuevo[0]['id_estado'] = 2;
			$this->rel()->tabla('libro')->set($fila_nuevo[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$viejo[0]['libro_id']));
			$fila_viejo = $this->rel()->tabla('libro')->get_filas();
			$fila_viejo[0]['id_estado'] = 1;
			$this->rel()->tabla('libro')->set($fila_viejo[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			$this->rel()->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();

			/*var_dump($fila_nuevo, $fila_viejo, $datos);
			exit();*/
			

			
			$this->set_pantalla('pant_inicial');
			$this->informar_msg('Datos Actualizados correcatamente!', 'info');
		}
	}


	function evt__cancelar()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- frm_agregar_prestamo ---------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__frm_agregar_prestamo__alta($datos)
	{
		$moroso = toba::consulta_php('consultas')->ver_moroso($datos['persona_id']);
		
		$cantidad_prestamo = toba::consulta_php('consultas')->puede_prestar($datos['persona_id']);
		/*var_dump($cantidad_prestamo[0]['libros_prestados'] > 3);
		exit();*/
			if ($cantidad_prestamo[0]['libros_prestados'] >= 3) {
				$this->informar_msg('supero el limte de 3 libros', 'info');
				return;
			}
			elseif($moroso[0]['count'] > 0){
				$this->informar_msg('Usted debe es moroso, devuelva el libro!!!', 'info');
				return;
			}else{

			$datos['devolucion'] = 'No';

			$id_l = $datos['libro_id'];

			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$id_l));
			$fila = $this->rel()->tabla('libro')->get_filas();
			$fila[0]['id_estado'] = 2;

			$this->rel()->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();
			
			$this->rel()->tabla('libro')->set($fila[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			
			$this->informar_msg('actualizo', 'info');
		}
	}

	function conf__frm_agregar_prestamo(leanInicial_ei_formulario $form)
	{
		$datos = $this->rel()->tabla('prestamo')->get();
		$form->set_datos($datos);
	}

}
?>