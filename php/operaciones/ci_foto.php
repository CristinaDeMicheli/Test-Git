<?php
class ci_foto extends leanInicial_ci
{
	protected $s__path_inicial;
	

	//-----------------------------------------------------------------------------------
	//---- foto_frm ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__foto_frm__alta($datos)
	{
		$foto_tmp = "";
		$imagen_a_tratar = ($datos['foto']);
		
		$ruta_final = 'img/imagenes/';

		$ruta_inicial = $this->s__path_inicial; 

		$this->s__path_inicial = toba::proyecto()->get_www($ruta_final);

		if (file_exists($ruta_inicial.$ruta_final)){
			
			$nombre_img = basename($datos['foto']['name']);
			$foto_tmp = $datos['foto']['tmp_name'];
			
			if (move_uploaded_file($foto_tmp, $ruta_final . $nombre_img)) {
				echo 'cargo';
				return;
			}else{
				echo 'no cargo';
			}


		}else{
			mkdir($ruta_inicial.$ruta_final);

			chmod($ruta_inicial.$ruta_final, 0777);

			$nombre_img = $ruta_inicial . $ruta_final . basename($datos['foto']['name']);
		}
		
	}

}
?>

