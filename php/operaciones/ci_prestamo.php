<?php
class ci_prestamo extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- frm_prestamo -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_prestamo(leanInicial_ei_formulario $form)
	{
		
	}

	function rel(){
		return $this->dep('datos');
	}

	function evt__frm_prestamo__alta($datos)
	{	
		/*var_dump($datos);
		exit();*/
		$moroso = toba::consulta_php('consultas')->ver_moroso($datos['persona_id']);
		$cantidad_prestamo = toba::consulta_php('consultas')->puede_prestar($datos['persona_id']);
		/*var_dump($cantidad_prestamo[0]['libros_prestados'] > 3);
		exit();*/
		if ($cantidad_prestamo[0]['libros_prestados'] > 3) {
			$this->informar_msg('supero el limte de 3 libros', 'info');
			return;
		}
		elseif($moroso[0]['count'] > 0){
			$this->informar_msg('Usted debe es moroso, devuelva el libro!!!', 'info');
			return;
		}else{
			
			$datos['devolucion'] = 'No'; 
			/*var_dump($datos);
			exit();*/
		toba::consulta_php('consultas')->actualizar_estado($datos['libro_id']);
		$this->rel()->tabla('prestamo')->set($datos);
		$this->rel()->tabla('prestamo')->sincronizar();
		$this->rel()->tabla('prestamo')->resetear();
		$this->informar_msg('Datos actualizados correctamente!', 'info');
		$this->set_pantalla('pant_inicial');
		}

		
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------


	function evt__frm_prestamo__baja()
	{
	}

	function evt__frm_prestamo__modificacion($datos)
	{
	}

	function evt__guardar()
	{

	}

}
?>