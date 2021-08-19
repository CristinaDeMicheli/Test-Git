<?php
class ci_abm_persona extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function rel(){
		return $this->dep('datos');
	}
	function evt__agregar()
	{
		$this->set_pantalla('pant_agregar');
	}

	function evt__cancelar()
	{
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
	}

	function evt__guardar()
	{
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_persona ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_persona(leanInicial_ei_cuadro $cuadro)
	{
		$datos = toba::consulta_php('consultas')->get_persona();
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_agregar_persona ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__frm_agregar_persona__alta($datos)
	{


		$cursor=$this->rel()->tabla('persona')->nueva_fila($datos);		
		$this->rel()->tabla('persona')->set_cursor($cursor);
		

		$this->rel()->tabla('persona_natural')->nueva_fila($datos);		
		
		$this->rel()->sincronizar();
		$this->rel()->resetear();
		
}
	function evt__cuadro_persona__seleccion($seleccion)
	{
		$this->rel()->tabla('persona')->cargar($seleccion);
		$this->rel()->tabla('persona_natural')->cargar($seleccion);
		$this->rel()->tabla('persona')->set_cursor(0);
		$this->rel()->tabla('persona_natural')->set_cursor(0);
		$this->set_pantalla('pant_agregar');
		/*$this->rel()->cargar($seleccion);
		$this->set_pantalla('pant_agregar');*/

	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	

	function conf__frm_agregar_persona(leanInicial_ei_formulario $form)
	{
		
		$datos = $this->rel()->tabla('persona')->get() + $this->rel()->tabla('persona_natural')->get();
		$form->set_datos($datos);

	}

	function evt__frm_agregar_persona__modificacion($datos)
	{

		
		$this->rel()->tabla('persona')->set($datos);
		$this->rel()->tabla('persona_natural')->set($datos);
		$this->rel()->tabla('persona')->sincronizar();
		$this->rel()->tabla('persona_natural')->sincronizar();
		$this->rel()->tabla('persona_natural')->resetear();
		$this->rel()->tabla('persona')->resetear();
		$this->informar_msg('Datos modificados exitosamente ', 'info');

		 $this->set_pantalla('pant_inicial');
		
	}

}
?>