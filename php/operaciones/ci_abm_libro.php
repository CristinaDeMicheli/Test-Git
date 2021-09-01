<?php
class ci_abm_libro extends leanInicial_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	//variable de sesion
	protected $s__datos_filtro;
	protected $s__path_inicial;
	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->evt__cancelar();
		$this->informar_msg('Datos guardados correctamente!', 'info');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(leanInicial_ei_cuadro $cuadro)
	{
		$filtro = null;
			if (isset($this->s__datos_filtro)){//preguntar si la variable esta seteada (tiene valores)
			$filtro = $this->dep('filtro_libro')->get_sql_where();//dame el objeto que representa el filtro  y pasalo por where
		}
		
		
		$datos = toba::consulta_php('consultas')->get_libro($filtro);
		//seteo el cuadro con la consulsta que traje de la carpeta "consultas"//
		$cuadro->set_datos($datos);
		//tmb se puede utilizar el return en lugar del set_datos pero no se podra realizar mas nada luego de eso
		//return $datos;	

	}

	function evt__cuadro__seleccion($seleccion)
	{
		/*$ruta_inicial = $this->s__path_inicial['path'];*/
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__formulario(leanInicial_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			//traigo lo que tengo cargo en el form despues del evento seleccion
			$datos = $this->dep('datos')->get();
			$img = $datos['foto'];


			$form->ef('imagen')->set_estado("<img src= '$img' width=150px height=auto>");
			$form->set_datos($datos);
		}
		
	}

	function evt__formulario__modificacion($datos)
	{
		if($_SERVER['HTTP_HOST'] === 'localhostt'){

		//DECLARO DOS VARIABLES PARA VERIFICAR SI ES QUE CAMBIO DE FOTO
			$foto_de_la_base ="";
			$foto_del_form = "";
			$nombre_img = '';
			$arreglo = "";
			$num_ram = 0;

		//declaro la variable para una foto no cargada
			$img_no_cargada = 'sinimagen.png';
		/*var_dump($datos);
		exit();*/
		//utilizo para guardar los datos que se van a modificar
		$s__datos['form'] = $datos;
		//modifico los valores
		/*DESDE ACA HAGO EL UPLOAD*/
		//delcaro el nombre de la variable a guardar
		$foto_guardar = "";
		//declaro la variable a trabajar sobre el archivo temporarl
		$foto_tmp = "";
		//declaro la variable con el arreglo de la foto del upload
		$imagen_a_tratar = ($datos['imagen']);

		/*var_dump($imagen_a_tratar);
		exit();*/
		//IMAGEN A TRATA ME TRAE LA SELECCION DEL FORM

		//declaro la ruta donde voy a guardar las fotos
		$ruta_final = 'img/imagenes/';

		//obtengo la ruta inicial del archivo
		$this->s__path_inicial = toba::proyecto()->get_www($ruta_final);

		//declaro la ruta inicial del archivo
		$ruta_inicial = $this->s__path_inicial['path']; 

		$path = $ruta_inicial;
		
		//pregunto si existe el fichero donde voy a guardar los archivos
		if (!file_exists($path)){
			//si no existe la ruta, la creo y doy permisos de adm
			mkdir($path);
			//doy peromisos de adm
			chmod($path, 0777);
		}
			//guardo el nombre de la imagen
		/*$nombre_img = basename($imagen_a_tratar['name']);*/

		if ($imagen_a_tratar['name'] !== '') {
			//usar imagen a tratar

			//traigo la imagen que tnego en mi bd
			$foto_de_la_base = toba::db()->consultar("SELECT foto from curlib.libro where id_libro ='$datos[id_libro]'");
			
			if($imagen_a_tratar !== null) {
			//guardo el nombre del archivo temporal
				$foto_tmp = $datos['imagen']['tmp_name'];
			//creo un numero aletario para el nombre del archivo
				$num_ram = mt_rand(0,10000);
				$foto_guardar = $ruta_final . $imagen_a_tratar['name'];
			//separo la ruta a partir del punto
				$arreglo = explode(".",$foto_guardar);
			//concateno el numero aleatorio y lo guardo en $foto_guardar
				$foto_guardar = $arreglo[0] . $num_ram . "." . $arreglo[1];
				//pregunto si cargo, no es necesario el if
			}
			if (move_uploaded_file($foto_tmp, $foto_guardar)) {				
				$datos["foto"] = $foto_guardar;
				$var = explode("/", $path);
				$path_corto = $var[0]."/".$var[1]."/".$var[2]."/".$var[3]."/";

				if ($foto_de_la_base[0]['foto'] !== 'img/imagenes/sinimagen.png') {
					if(file_exists($path_corto.$foto_de_la_base[0]['foto'])){
						unlink($path_corto.$foto_de_la_base[0]['foto']);
					}
					
				}
			}
		}else{
			$foto_guardar = $ruta_final . $img_no_cargada;
			$datos["foto"]=$foto_guardar;
			$datos['ejemplar'] = 1;
		}
		
		
		$this->dep('datos')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
	}else{
		echo "no estas en localhost";
		return;
	}

}
	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//los conf__ se ejecutan antes de que se muestre la pantalla

function conf__pant_edicion(toba_ei_pantalla $pantalla)
{
		//pregunto si hay algo carGado, en caso de que no, me saque el boton eliminar
	if (!$this->dep('datos')->esta_cargada()) {
		$pantalla->eliminar_evento('eliminar');
	}
}


	//-----------------------------------------------------------------------------------
	//---- filtro_libro -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

function evt__filtro_libro__filtrar($datos)
{
	$this->s__datos_filtro = $datos;
}

function conf__filtro_libro(leanInicial_ei_filtro $filtro)
{
		//PREGUNTO SI TENGO DATOS EN EL FILTRO
	if (isset($this->s__datos_filtro)){
		$filtro->set_datos($this->s__datos_filtro);
	} 
}

function evt__filtro_libro__cancelar()
{
	unset($this->s__datos_filtro);
}

}

function get_conexion_ssh2()
    {
        $sftp = null;
        if(!($conexion_ssh = ssh2_connect('192.168.10.200', 22))){
            toba::notificacion()->vaciar();
            toba::notificacion()->set_titulo('Sistema de Biblioteca...');
            toba::notificacion()->agregar('ATENCION: Ha fallado la conexión SSH con el servidor de Desarrollo.
                                           <br> Las imágenes no se descargarán apropiadamente.');
        }
        else{
            ssh2_auth_password($conexion_ssh, 'root', 'roda1950');
            $sftp = ssh2_sftp($conexion_ssh);
        }
        
        return $sftp;
    }
?>