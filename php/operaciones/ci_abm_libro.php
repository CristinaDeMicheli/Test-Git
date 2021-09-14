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
		$sftp=$this->conexion_ssh();
		if ($this->dep('datos')->esta_cargada()) {
			//traigo lo que tengo cargo en el form despues del evento seleccion
			$datos = $this->dep('datos')->get();
			$img = $datos['foto'];

			

			$nombre_img = explode("/", $img);
			/*var_dump($nombre_img);
			exit();
			$content = file_get_contents("ssh2.sftp://".$sftp."/var/www/documentos/libros/".$nombre_img[5]);*/
			$image = "ssh2.sftp://".$sftp."/var/www/documentos/libros/".$nombre_img[5];
			if (!is_null($image)) {
				$imagen = 'imagen.png';
			$result=file_get_contents($image);
    		file_put_contents($imagen, $result);
			}
			
			
			$form->ef('imagen')->set_estado("<img src= '$imagen' width=150px height=auto>");
			$form->set_datos($datos);
		}
		
	}

	public function conexion_ssh(){
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
	function evt__formulario__modificacion($datos){

		$sftp=$this->conexion_ssh();
		$ruta_server = '/var/www/documentos/libros/';
		$foto_tmp = $datos['imagen']['tmp_name'];
		$foto_guardar = $datos['imagen']['name'];
			/*var_dump($foto_tmp);
			exit();
			*/
			$var = ssh2_sftp_chmod($sftp, '/var/www/documentos/libros/', 0777);
			if ($var === false) {
				ssh2_sftp_mkdir($sftp, $ruta_server);
			}
			$num_ram= mt_rand(0,10000);
			$foto_guardar = $ruta_server . $foto_guardar;


			$arreglo = explode(".",$foto_guardar);

			$foto_guardar = $arreglo[0] . $num_ram . "." . $arreglo[1];

			if (move_uploaded_file($foto_tmp, 'ssh2.sftp://'.$sftp.$foto_guardar)) 
			{
				echo 'cargo';      
			}
			$datos['foto'] = $foto_guardar;
			$this->dep('datos')->set($datos);
			$this->dep('datos')->sincronizar();
			$this->dep('datos')->resetear();
			$this->set_pantalla('pant_inicial');	
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

/*function get_conexion_ssh2()
{

	if(($_SERVER['SERVER_NAME'] == 'localhost') xor  ($_SERVER['SERVER_NAME'] == '172.25.50.200') xor  ($_SERVER['SERVER_NAME'] == '192.168.10.200') xor  ($_SERVER['SERVER_NAME'] == 'desarrollo.ciudaddecorrientes.gov.ar') )
	{
		$pdo = new PDO('pgsql:host=172.25.50.200;port=5432;dbname=bdSueldos', 'postgres', '09dgc06mcc');
	}


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
}*/

?>