<?php
class js_agregar_prestamo extends leanInicial_ei_formulario
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
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__libro_id__procesar = function(es_inicial)
		{
			const fecha = new Date()
			fechaS = fecha.toLocaleDateString()
			if(this.ef('libro_id').get_estado() !== ''){
			this.ef('fecha_alta').set_estado(fechaS)
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__plazo__procesar = function(es_inicial)
		{
			if(this.ef('plazo').get_estado() !== ''){
				dias = this.ef('plazo').get_estado()
				diaI = parseInt(dias, 10)
				const fecha = new Date()
				fecha.setDate(fecha.getDate() + diaI)
				fecha2 = fecha.toLocaleDateString()
				this.ef('fecha_venc').set_estado(fecha2)
			}
			if(this.ef('plazo').get_estado() !== ''){
				this.ef('libro_id').set_solo_lectura(false)
				this.ef('persona_id').set_solo_lectura(false)
				this.ocultar_boton('modificar')
			}else if (this.ef('plazo').get_estado() === ''){
				this.ocultar_boton('modificar')
			}
		}
		";
	}


}
?>