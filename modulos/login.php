<?php


    if(isset($registrar)){
        redir("?p=registro");
    }



	if (isset($enviar)) {
		$correo = clear($correo);
		$password = clear($password);
	

	$q = $mysqli->query("SELECT * FROM clientes WHERE correo = '$correo' AND contraseña = '$password'");

	if (mysqli_num_rows($q)>0) {
		$r = mysqli_fetch_array($q);
		$_SESSION['id_cliente'] = $r['id_cliente'];
		if (isset($return)) {
			redir("?p=inicio");
		}else{
			redir("?p=inicio");
		}
	}else{
		alert("El cliente ingresado no esta registrado",0,'login');
		redir("?p=login");
	}


}

if (isset($_SESSION["id_cliente"])) { //sesion iniciada


}else{ //sesion no iniciada
	?>
<center>
	<form method="post" action="">
		<div class="centrar_login">
			<label><h1 style="color: #553F10"><i class="fa fa-user"></i> Iniciar Sesión</h1></label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Correo: ej@ejemplo.com" name="correo"/>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Contraseña" name="password">
			</div>
			<div class="form-group">
				<button style="background: #553F10 ;border: #0a0a0a; color: beige;" class="btn btn-submit" name="enviar" type="submit"><i class="fa-li fa fa-check-square"></i>Ingresar</button>
			</div>
			<div class="form-group">
				<button style="background: beige ;border: #0a0a0a;" class="btn btn-submit" name="registrar" type="submit"><i class="fa-li fa fa-check-square"></i>Registrarse</button>
			</div>
		</div>
	</form>
</center>
<?php
}
?>
