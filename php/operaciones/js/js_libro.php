<?php
class js_libro extends leanInicial_ei_formulario
{
	function generar_layout()
	{
		$this->generar_html_ef('titulo');
		$this->generar_html_ef('resumen');
		$this->generar_html_ef('id_genero');
		$this->generar_html_ef('id_autor');
		$this->generar_html_ef('id_editorial');
		$this->generar_html_ef('estante');
		$this->generar_html_ef('id_estado');
		$this->generar_html_ef('adquicision_id');
		$this->generar_html_ef('isbn');
		$this->generar_html_ef('anio');
		$this->generar_html_ef('imagen');
	}


	

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__titulo__procesar = function(es_inicial)
		{
			if(this.ef('titulo').get_estado() !== ''){
				this.ef('id_estado').set_estado(1);
			}
		}
		
		";
	}



}
?>