<?php
class js_prestamo extends leanInicial_ei_formulario
{
	function generar_layout()
	{
		$this->generar_html_ef('libro_id');
		$this->generar_html_ef('persona_id');
		$this->generar_html_ef('fecha_alta');
		$this->generar_html_ef('plazo');
		$this->generar_html_ef('fecha_venc');
		$this->generar_html_ef('devolucion');
		$this->generar_html_ef('id_prestamo');
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		
		
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__cancelar = function()
		{
			
			this.ef('libro_id').set_solo_lectura(false)
			this.ef('persona_id').set_solo_lectura(false)
			this.ocultar_boton('modificacion')
			/*this.mostar_boton('alta')*/
			return false
		}
		";
	}




}
?>