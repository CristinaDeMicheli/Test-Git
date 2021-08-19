<?php
class js_test extends leanInicial_ei_formulario
{
	

	function generar_layout()
	{
		$this->generar_html_ef('libro_id');
		$this->generar_html_ef('persona_id');
		$this->generar_html_ef('fecha_alta');
		$this->generar_html_ef('plazo');
		$this->generar_html_ef('fecha_venc');
		$this->generar_html_ef('id_prestamo');
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		
		{$this->objeto_js}.evt__cancelar = function()
		{
			this.ef('libro_id').set_solo_lectura(false)
			this.ef('persona_id').set_solo_lectura(false)
			this.ocultar_boton('modificacion')
			this.ocultar_boton('cancelar')
			this.mostrar_boton('modificar')
			return false
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__plazo__procesar = function(es_inicial)
		{
			if(this.ef('plazo').get_estado() !== ''){
				this.ef('libro_id').set_solo_lectura(true)
				this.ef('persona_id').set_solo_lectura(true)
				this.ocultar_boton('modificar')
			}else if (this.ef('plazo').get_estado() === ''){
				this.ocultar_boton('modificar')
			}
		}
		";
	}




}
?>