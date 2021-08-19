<?php
class ci_popup_persona extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
	}

	function evt__cancelar()
	{
	}

	function evt__eliminar()
	{
	}

	function evt__guardar()
	{
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_popup_persona ---------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_popup_persona(leanInicial_ei_cuadro $cuadro)
	{
		$cuadro->desactivar_modo_clave_segura();
		$datos = toba::consulta_php('consultas')->get_persona();
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_popup_persona ---------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_popup_persona(leanInicial_ei_filtro $filtro)
	{
	}

	function evt__filtro_popup_persona__filtrar($datos)
	{
	}

	function evt__filtro_popup_persona__cancelar()
	{
	}

	static function get_persona_pp($id=0)
	{
		$rs = toba::db()->consultar("SELECT apyn  FROM cidig.persona_natural WHERE id_persona = ".$id);
		$valor = "No se pudo identificar el Id. persona: ".$id;

		if(count($rs) > 0 ){
			$valor = $rs[0]['apyn'];
		}

		return $valor;
	}


	static function get_dni_persona_pp($id=0){
		$rs = toba::db()->consultar("SELECT cuil_documento  FROM cidig.persona WHERE id_persona = ".$id);
		$valor = "No se pudo identificar el Id. persona: ".$id;
		if(count($rs) > 0 ){
			$valor = $rs[0]['cuil_documento'];
		}
		return $valor;	
	}
}

?>