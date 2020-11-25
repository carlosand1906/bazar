<?php
if (isset($_SESSION['id_cliente'])) {
	redir("./");
}

if (isset($enviar)) {
	$nombre = clear($nombre);
	$direccion = clear($direccion);
	$codigo_postal = clear($codigo_postal);
	$direccion = clear($direccion);
    $correo = clear($correo);
	$telefono = clear($telefono);
	$tarjeta = clear($tarjeta);
	$banco = clear($banco);
	$cvv = clear($cvv);
	$contraseña1 = clear($contraseña1);
	$contraseña2 = clear($contraseña2);	



	$q = $mysqli->query("SELECT * FROM clientes WHERE correo = '$correo'");

	if (mysqli_num_rows($q)>0) {
		alert("El usuario esta registrado");
		redir("");
	}

	if ($contraseña1 != $contraseña2) {
		alert("No coincide contraseña");
		redir("");
	}

	$mysqli->query("INSERT INTO clientes (nombre, direccion, codigo_postal, correo, telefono, tarjeta, banco, cvv, contraseña) VALUES ('$nombre','$direccion','$codigo_postal','$correo','$telefono','$tarjeta','$banco','$cvv','$contraseña1')");

	$q2 = $mysqli->query("SELECT * FROM clientes WHERE correo = '$correo'");

	$r = mysqli_fetch_array($q2);

	$_SESSION['id_cliente'] = $r['id_cliente'];

	alert("Cliente registrado exitosamente");
	alert("Su numero de usuario es: ".$r['id_cliente']);
	redir("./");
}
?>

<br>

<center>
	<form method="post" action="">
	<div class="centrar_registro">
			<label><h2 style="color: #553F10"><i class="fa fa-key"></i>Registrate como Cliente</h2></label><br>
		<div class="form-group">
			<input type="text" autocomplete="off" class="form-control" placeholder="Nombre completo" name="nombre" required="">
		</div>
		<div class="form-group">
			<input type="text" autocomplete="off" class="form-control" placeholder="Domicilio: Calle, Numero, Colonia, Ciudad, Estado" name="direccion" required="">
		</div>
    	<div class="form-group">
			<input type="text" autocomplete="off" class="form-control" placeholder="Codigo Postal" name="codigo_postal" required="">
		</div>
		<div class="form-group">
			<input type="email" autocomplete="off" class="form-control" placeholder="Ej: cliente@ejemplo.com" name="correo" required="">
		</div>
		<div class="form-group">
			<input type="text"  autocomplete="off" class="form-control" placeholder="lada - Telefono (casa)" maxlength="10"  onkeypress="return validaNumericos(event)" name="telefono" required="">
		</div>
		<div class="form-group">
			<input type="text"  autocomplete="off" class="form-control" placeholder="Num. Tarjeta" maxlength="16"  onkeypress="return validaNumericos(event)" name="tarjeta" required="">
		</div>
		<div class="form-group">
			<select name="banco" class="form-control" required="">
			    <option value="">Seleccione el banco al que pertenece</option>
				<option value="HSBC">HSBC</option>
				<option value="Banorte">Banorte</option>
				<option value="Santander">Santander</option>
				<option value="BBVA Bancomer">BBVA Bancomer</option>
				<option value="Banamex">Banamex</option>
				<option value="ScotiaBank">ScotiaBank</option>
				<option value="BanRegio">BanRegio</option>
				<option value="Afirme">Afirme</option>
				<option value="Banco Azteca">Banco Azteca</option>
				<option value="BanCoppel">BanCoppel</option>
		</select>
		</div>
		<div class="form-group">
			<input type="text"  autocomplete="off" class="form-control" placeholder="Codigo de seguridad de tarjeta (CVV)" maxlength="3"  onkeypress="return validaNumericos(event)" name="cvv" required="">
		</div>
		<div class="form-group">
			<input type="password" autocomplete="off" class="form-control" placeholder="Contraseña" name="contraseña1" required="">
		</div>
		<div class="form-group">
			<input type="password" autocomplete="off" class="form-control" placeholder="Confirmar contraseña" name="contraseña2" required="">
		</div>
		<div class="form-group">
			<button style="background: #553F10; border: #FFF6C0" type="submit" class="btn btn-success" name="enviar"><i class="fa fa-check"></i>Registrarse</button>
		</div>
	</div>
	</form>
</center>

<script type="text/javascript">
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}
</script>