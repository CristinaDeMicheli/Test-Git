<?php
	class consultas_libro
	{
		function get_libro($where = null){
			$sql = 'SELECT
		t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
			t_a.nombre as id_autor_nombre,
				t_e.nombre as editorial_nombre,
				t_g.descripcion as id_genero_descripcion, --"id_genero_descripcion va en la columna(*) del cuadro"
				t_l.estante,
				t_l.anio,
				t_l.isbn,
				t_l.foto,
				t_ad.descripcion as id_adquisicion_descripcion,
				t_es.descripcion as id_estado_nombre
				FROM
				curlib.libro as t_l
				INNER JOIN curlib.autor as t_a on t_l.id_autor = t_a.id_autor
				INNER JOIN curlib.editorial as t_e on t_l.id_editorial = t_e.id_editorial
				INNER JOIN curlib.estado as t_es on t_l.id_estado = t_es.id_estado
				INNER JOIN curlib.adquisicion as t_ad on t_l.adquicision_id = t_ad.id_adquisicion
				INNER JOIN curlib.genero as t_g on t_l.id_genero = t_g.id_genero ';
				if (!is_null($where)) {
					$sql .= "WHERE $where";
				}

			return toba::db()->consultar($sql);
		}

	/*agregue un comentario*/
	public function hola(){
		echo "hola";
		echo "esto es una prueba del torotise";
	}
	function hola2(){
		echo "hola";
		echo "prueba";
		echo "prueba";
		echo "prueba";
	}


	function get_genero(){
			$sql = ('SELECT
				t_g.id_genero as valor,
				t_g.descripcion as descripcion
				FROM
				curlib.genero as t_g JOIN curlib.libro as t_l ON (t_g.id_genero = t_l.id_genero)');
			return toba::db()->consultar($sql);
		}

		function get_autor(){
			$sql = ('SELECT 
				t_a.id_autor as id_autor,
				t_a.nombre as nombre_autor
			 FROM curlib.autor as t_a');
			return toba::db()->consultar($sql);
		}

		function get_editorial(){
			$sql = ('SELECT
					t_e.id_editorial as id_editorial,
					t_e.nombre as editorial_nombre,
					t_e.domicilio as domicilio,
					t_e.persona_contacto as contacto,
					t_e.telefonos as telefono
					FROM
					curlib.editorial as t_e
				');
			return toba::db()->consultar($sql);
		}

		function get_estado(){
			$sql = ('SELECT
				t_es.id_estado as id_estado,
				t_es.descripcion as estado_descripcion
				FROM
				curlib.estado as t_es');
		return toba::db()->consultar($sql);
		}

		function get_adquisicion(){
			$sql = ('SELECT
				t_a.id_adquisicion as adquisicion_id,
				t_a.descripcion as adquisicion_descripcion
				FROM
				curlib.adquisicion as t_a');
		return toba::db()->consultar($sql);	
		}

		/*QUERY PARA GENERO*/
		function get_descripciones($where = null)
			{
			$sql = 'SELECT t_g.id_genero as id_genero,
			 t_g.descripcion as descripcion
			 FROM curlib.genero as t_g ';
			 if (!is_null($where)) {
			 	$sql .= "WHERE $where";
			 }
			return toba::db()->consultar($sql);
			}
	/*FIN QUERY PARA GENERO*/

	/*QUERY PARA CATEGORIA*/
	function get_categoria()
	{
		$sql = "SELECT id_categoria, descripcion FROM categoria ORDER BY categoria";
		return toba::db('leanInicial')->consultar($sql);
	}
	/*FIN QUERY PARA CATEGORIA*/


	/*ESTO POR EL MOMENTO si LO VOY A OCUPAR*/
	function get_persona($where = null){
	$sql = 'SELECT persona_natural.id_persona as id_persona,
					persona_natural.apyn as apyn,
					persona_natural.id_sexo,
					persona_natural.fe_nac as fe_nac,
					persona.cuil_documento as dni,
					persona.id_persona_tipo
				FROM cidig.persona
				INNER JOIN cidig.persona_natural on persona.id_persona = persona_natural.id_persona 
				WHERE persona.id_persona_tipo = 1 ';
				if (!is_null($where)) {
			 	$sql .= "AND $where";
			 }else{
			 	$sql .= "LIMIT 100";
			 }
				return toba::db()->consultar($sql);
	}




	function get_libro_disponible(){
			$sql = 'SELECT
		t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
			t_a.nombre as id_autor_nombre,
				t_e.nombre as editorial_nombre,
				t_g.descripcion as id_genero_descripcion, --"id_genero_descripcion va en la columna(*) del cuadro"
				t_l.estante,
				t_l.anio,
				t_l.isbn,
				t_ad.descripcion as id_adquisicion_descripcion,
				t_es.descripcion as id_estado_nombre
				FROM
				curlib.libro as t_l
				INNER JOIN curlib.autor as t_a on t_l.id_autor = t_a.id_autor
				INNER JOIN curlib.editorial as t_e on t_l.id_editorial = t_e.id_editorial
				INNER JOIN curlib.estado as t_es on t_l.id_estado = t_es.id_estado
				INNER JOIN curlib.adquisicion as t_ad on t_l.adquicision_id = t_ad.id_adquisicion
				INNER JOIN curlib.genero as t_g on t_l.id_genero = t_g.id_genero 
				WHERE t_l.id_estado = 1';
				return toba::db('leanInicial')->consultar($sql);
			}

	function puede_prestar($id){
		$sql = "SELECT COUNT(*) as libros_prestados 
		FROM curlib.prestamo as p 
		JOIN curlib.libro as l on p.libro_id = l.id_libro 
		where l.id_estado = 2 and p.devolucion = 'No' and p.persona_id = ".$id;
	return toba::db()->consultar($sql);
	}

	function ver_moroso($id){
		$sql = "
			SELECT count(*) from curlib.prestamo
			where fecha_venc < current_date and devolucion = 'No' and persona_id = ".$id
		;
		return toba::db()->consultar($sql);
	}

	function get_prestamo_id($id){
		$sql = "
			SELECT * FROM curlib.prestamo WHERE id_prestamo = ".$id
		;
		return toba::db()->consultar($sql);
	}

	function get_prestamo($where = null){

		$sql = "SELECT 	pres.id_prestamo as id_prestamo,
						per.apyn as nya,
						lib.titulo as titulo,
						pres.fecha_alta as f_alta,
						pres.fecha_venc as f_dev,
						perr.cuil_documento as cuil,
						CASE
						WHEN pres.devolucion = 'No' and (pres.fecha_venc - current_date) > 0
						THEN pres.fecha_venc - current_date 
						ELSE 0
						END as dias_entrega,
						pres.devolucion as devuelto,
						lib.isbn as isbn
			FROM curlib.prestamo as pres
			INNER JOIN curlib.libro as lib on pres.libro_id = lib.id_libro
			INNER JOIN cidig.persona_natural as per on pres.persona_id = per.id_persona
			INNER JOIN cidig.persona as perr on per.id_persona = perr.id_persona WHERE lib.id_estado = 2 and devolucion = 'No'";
			if (!is_null($where)) {
				$sql .= " and $where";
			/*				var_dump($sql);
			exit();*/
			}
			return toba::db()->consultar($sql);
		}


		function get_persona_id($id){
	$sql = 'SELECT persona_natural.id_persona as id_persona,
					persona_natural.apyn as apyn,
					persona_natural.fe_nac as fe_nac,
					persona.cuil_documento as dni
				FROM cidig.persona
				INNER JOIN cidig.persona_natural on persona.id_persona = persona_natural.id_persona
				WHERE persona.id_persona = '.$id;
				return toba::db()->consultar($sql);
	}

	function actualizar_estado($id){
		$sql = 'UPDATE curlib.libro SET id_estado = 2 WHERE id_libro = '.$id;

		toba::db('leanInicial')->consultar($sql);			
	}


	function actualizar_estado_si($id){
		$sql = 'UPDATE curlib.libro SET id_estado = 1 WHERE id_libro = '.$id;

		toba::db('leanInicial')->consultar($sql);		
	}

	function get_id_libro_de_prestamo($id){
		$sql ="
			SELECT libro_id FROM curlib.prestamo WHERE id_prestamo = ".$id;
		return toba::db()->consultar($sql);
	}

	function get_id_libro($id){
		$sql ="
			SELECT * FROM curlib.libro WHERE id_libro = ".$id;
		return toba::db()->consultar($sql);
	}

	/*function actualizar_prestamo($id_l, $id_p, $pres){

		$sql = "UPDATE curlib.prestamo SET libro_id = $id_l,
											persona_id = $id_p							
		WHERE id_prestamo = ".$pres;

		toba::db('leanInicial')->consultar($sql);
	}*/


	function ver_prestamos_por_persona($id){
		$sql = "
			SELECT 
				count(libro_id) as cantidad,
				t_per2.cuil_documento,
				t_per.id_persona,
				t_per.apyn, string_agg(t_lib.titulo, ' ,' ) as libros
				FROM curlib.prestamo as t_pres
				INNER JOIN curlib.libro as t_lib on (t_pres.libro_id = t_lib.id_libro)
				INNER JOIN cidig.persona_natural t_per on (t_pres.persona_id = t_per.id_persona)
				INNER JOIN cidig.persona as t_per2 on (t_pres.persona_id = t_per2.id_persona)
			WHERE t_pres.persona_id = $id
			GROUP BY t_per2.cuil_documento, t_per.apyn, t_per.id_persona
		";
		return toba::db()->consultar($sql);
	}

	function get_cond_fiscal(){
		$sql = "
			SELECT * FROM cidig.cond_fiscal;
		";
		return toba::db()->consultar($sql);
	}

	function get_sexo(){
		$sql = "
			SELECT * FROM cidig.sexo;
		";
		return toba::db()->consultar($sql);
	}

	function get_genero_per(){
		$sql = "
			SELECT * FROM cidig.genero;
		";
		return toba::db()->consultar($sql);
	}

	function get_persona_tipo(){
		$sql = "
			SELECT * FROM cidig.persona_tipo;
		";
		return toba::db()->consultar($sql);
	}

	function get_estado_civil(){
		$sql = "
			SELECT * FROM cidig.estado_civil;
		";
		return toba::db()->consultar($sql);
	}

}
?>

