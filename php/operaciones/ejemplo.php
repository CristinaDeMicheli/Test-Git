<?php 
function evt__formulario__modificacion($datos){
		//declaro una variable para traer la foto de la base en caso de tenerla
		$foto_de_la_base = "";
		$foto_frm = $datos['imagen'];
		//se si modifico o no ($libro_id)
		$libro_id = $datos['id_libro'];
		//declaro la ruta donde voy a guardar las fotos
		$ruta_final = 'img/imagenes/';
		//obtengo la ruta inicial del archivo
		$this->s__path_inicial = toba::proyecto()->get_www($ruta_final);
		//declaro la ruta inicial del archivo
		$ruta_inicial = $this->s__path_inicial['path'];
		$path = $ruta_inicial;
		var_dump($path);
		exit();
		//declaro el nombre de la foto que va a ir x defecto
		$img_no_cargada = 'sinimagen.png';
		
		if ($_SERVER['SERVER_NAME'] === 'localhost') { // quedo abierto
			//VERIFICO SI REALIZO UN ALTA SIN FOTO
			//DESCA ACA ESTO EN LOCAL PARA HACER EL UPLOAD
			if (is_null($foto_frm) && is_null($libro_id)) {
				//pregunto si existe el fichero donde voy a guardar los archivos
				if (!file_exists($path)){
					//si no existe la ruta, la creo y doy permisos de adm
					mkdir($path);
					//doy peromisos de adm
					chmod($path, 0777);
				}
					//cargo la imagen x defecto
				$foto_guardar = $ruta_final . $img_no_cargada;
				$datos["foto"]=$foto_guardar;
				$datos['ejemplar'] = 1;
			}elseif(!is_null($libro_id)){
				$foto_de_la_base = toba::db()->consultar("SELECT foto from curlib.libro where id_libro = '$libro_id'");
					//VERIFICO SI EL REGISTRO TIENE UNA IMAGEN VACIA
				if (is_null($foto_de_la_base[0]['foto']) || $foto_de_la_base[0]['foto'] === '') {
					$foto_guardar = $ruta_final . $img_no_cargada;
					$datos["foto"]=$foto_guardar;
					//verifico que haya algo en la foto de la base
				}else{
					if (!is_null($datos['imagen'])) {
						$num_ram = 0;
						$foto_guardar = $datos['imagen']['name'];
						$foto_tmp = $datos['imagen']['tmp_name'];
						$num_ram = mt_rand(0,10000);
						$foto_guardar = $ruta_final . $foto_guardar;
						$arreglo = explode(".",$foto_guardar);
						$foto_guardar = $arreglo[0] . $num_ram . "." . $arreglo[1];

						if (move_uploaded_file($foto_tmp, $foto_guardar)) {
							$datos['foto'] = $foto_guardar;
							$var = explode("/", $path);
							$path_corto = $var[0]."/".$var[1]."/".$var[2]."/".$var[3]."/";
							if ($foto_de_la_base[0]['foto'] !== 'img/imagenes/sinimagen.png') {
								if(file_exists($path_corto.$foto_de_la_base[0]['foto'])){
									unlink($path_corto.$foto_de_la_base[0]['foto']);
								}	
							}
						}
					}
				}
			}else{
				$num_ram = 0;
				$foto_guardar = $datos['imagen']['name'];
				$foto_tmp = $datos['imagen']['tmp_name'];
				$num_ram = mt_rand(0,10000);
				$foto_guardar = $ruta_final . $foto_guardar;
				$arreglo = explode(".",$foto_guardar);
				$foto_guardar = $arreglo[0] . $num_ram . "." . $arreglo[1];
				if (move_uploaded_file($foto_tmp, $foto_guardar)) {
					$datos['foto'] = $foto_guardar;
				}
			}
			$this->dep('datos')->set($datos);
			$this->dep('datos')->sincronizar();
			$this->dep('datos')->resetear();
			$this->set_pantalla('pant_inicial');	
		}
		elseif($_SERVER['SERVER_NAME'] === '192.168.10.200'){
			$destino = 'var/www/documentos/libros';
			if (!file_exists($destino)) {
				//si no existe la ruta, la creo y doy permisos de adm
				mkdir($destino);
			//doy peromisos de adm
				chmod($destino, 0777);
			}
		}
}
?>