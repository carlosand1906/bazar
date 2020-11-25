<?php
	check_user('comprobante');

	if (isset($subir)) {
		$id_cliente = $_SESSION['id_cliente'];
		$comprobante = "";

		if (is_uploaded_file($_FILES['comprobante']['tmp_name'])) {
			$comprobante = date("His").rand(0,1000).".pdf";
			move_uploaded_file($_FILES['comprobante']['tmp_name'], "comprobantes/".$comprobante);
		}
	$qs = $mysqli->query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente'");

		$rs = mysqli_fetch_array($qs);
		$nombre = $rs['nombre'];

	$mysqli->query("INSERT INTO pagos(id_cliente, nombre_cliente, comprobante, fecha, estado) VALUES ('$id_cliente', '$nombre','$comprobante',NOW(),'0')");

		alert("Comprobante enviado");

	}

?>

<br>
<h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-credit-card"></i> Métodos de Pago</h1>
<br>

<table class="table table-striped">
	<tr style="color: #553F10">
		<th>Tipos de Pago</th>
		<th>Cuenta</th>
		<th>Titular</th>
		<th>Acciones</th>
	</tr>

<?php
if (isset($_SESSION['id_cliente'])) {
		$id_cliente = $_SESSION['id_cliente'];

	$q = $mysqli->query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente'");
	while ($r = mysqli_fetch_array($q)) {
?>

	<tr>
		<td>Transferencia Bancaria</td>
		<td>1234123412341234</td>
		<td>BazaarMexico S.A. de C.V.</td>
		<td><a target="_blank" href="https://google.com"> Ir a pago</a></td>
	</tr>
</table>

<?php
	}
}
?>

<h2  style="color: #553F10" aria-hidden="true">Enviar comprobante de pago</h2>
<br>

<form method="post" action="" enctype="multipart/form-data">
	<div class="form-group">
		<label><small>Adjuntar archivo</small></label>
		<input type="file" name="comprobante" title="Adjuntar archivo" required/>
	</div>
	<div class="form-group">
		<input style="background: #553F10; border: #0a0a0a;" type="submit" name="subir" class="btn btn-primary" value="Enviar"/>
	</div>
</form>