<?php
class ci_crud_libros extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro_libros ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_libros(leanInicial_ei_cuadro $cuadro)
	{
	}

	function evt__cuadro_libros__seleccion($seleccion)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(leanInicial_ei_cuadro $cuadro)
	{
	}

	function evt__cuadro__seleccion($seleccion)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__agregar = function()
		{
		}
		
		{$this->objeto_js}.evt__cancelar = function()
		{
		}
		
		{$this->objeto_js}.evt__eliminar = function()
		{
		}
		
		{$this->objeto_js}.evt__guardar = function()
		{
		}
		";
	}

}
?>