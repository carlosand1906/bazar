 <?php

 	include "config.php";

		$host_mysql = "localhost";
		$user_mysql = "root";
		$pass_mysql = "";
		$db_mysql = "bazar";

	$mysqli=mysqli_connect($host_mysql,$user_mysql,$pass_mysql,$db_mysql);

	function clear($var){
		htmlspecialchars($var);

		return $var;
	}

	function check_admin($url){
		if (isset($_SESSION['id_usuario'])) {
			
		}else{
            redir("?p=login&return=$url");	
        }
	}

	function redir($var){
		?>
		<script>
			window.location="<?=$var?>";
		</script>
		<?php
		die();
	}

	function alert($var){
		?>
		<script type="text/javascript">
			alert("<?=$var?>");
		</script>
		<?php
	}

	function check_user($url){
		if (isset($_SESSION['id_cliente'])) {

		}else{
			redir("?p=login&return=$url");			
		}
	}

	function nombre_cliente($id_cliente){
		$mysqli = connect();

		$q = $mysqli->query("SELECT * FROM cliente WHERE id_cliente= '$id_cliente'");
		$r = mysqli_fetch_array($q);
		return $r['id_cliente'];
	}

	function connect(){
			$host_mysql = "localhost";
			$user_mysql = "root";
			$pass_mysql = "";
			$db_mysql = "tiendita";

			$mysqli=mysqli_connect($host_mysql,$user_mysql,$pass_mysql,$db_mysql);

			return $mysqli;
	}

	function fecha($fecha){
		$e = explode("-", $fecha);

		$year = $e[0];
		$month = $e[1];
		$e2 = explode(" ", $e[2]);
		$day = $e2[0];

		return $day."/".$month."/".$year;
	}

	function estado($id_estado){
		if ($id_estado == 0) {
			$estatus = "Iniciado";
		}elseif ($id_estado == 1) {
			$estatus = "Preparando";
		}elseif ($id_estado == 2) {
			$estatus = "En camino";
		}elseif ($id_estado == 3) {
			$estatus = "Entregado";
		}else{
			$estatus = "Indefinido";
		}

		return $estatus;

	}

	function admin_nombre_conectado(){
		$id_usuario = $_SESSION['id_usuario'];
		$mysqli = connect();

		$q = $mysqli->query("SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
		$r = mysqli_fetch_array($q);

		return $r['nombre_c'];
	}

	function estado_pago($estado){
		if ($estado == 0) {
			$estatus = "Sin Verificar";
		}elseif ($estado == 1) {
			$estatus = "Verificado y Modificado";
		}elseif ($estado == 2) {
			$estatus = "Reembolso";
		}else{
			$estatus = "Indefinido";
		}

		return $estatus;

	}
?>