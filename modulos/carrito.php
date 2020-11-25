<?php
	if (isset($_SESSION['id_cliente'])) {

		if (isset($eliminar)) {
			$id_cliente = clear($_SESSION['id_cliente']);
			$eliminar = clear($eliminar);
			$mysqli->query("DELETE FROM carrito WHERE folio = '$eliminar' AND id_cliente = '$id_cliente'");
            alert("Producto eliminado del carrito");
			redir("?p=carrito");
		}

		if (isset($cod) && isset($modificar)) {
			$id_cliente = clear($_SESSION['id_cliente']);
			$cod = clear($cod);
			$modificar = clear($modificar);

			$mysqli->query("UPDATE carrito SET cantidad = '$modificar' WHERE folio = '$cod' AND id_cliente = '$id_cliente'");
			alert("Cantidad modificada");
			redir("?p=carrito");
		}








	if (isset($finalizar)) {

		$monto = clear($monto_total);
		$id_cliente = clear($_SESSION['id_cliente']);
		$q = $mysqli->query("INSERT INTO venta (id_cliente, fecha, hora, total, estado) VALUES ('$id_cliente',NOW(), NOW(),'$monto',0)");

		$sc = $mysqli->query("SELECT * FROM venta WHERE id_cliente = '$id_cliente' ORDER BY folio_v DESC LIMIT 1");
		$rc = mysqli_fetch_array($sc);

		$ultima_venta = $rc['folio_v'];

		$q2 = $mysqli->query("SELECT * FROM carrito WHERE id_cliente = '$id_cliente'");

	while ($r2=mysqli_fetch_array($q2)) {

		$sp = $mysqli->query("SELECT * FROM inventario WHERE codigo_barras = '".$r2['codigo_barras']."'");
		$rp = mysqli_fetch_array($sp);

		$precio_total2 = 0;

	if ($rp['oferta']>0) {
	if (strlen($rp['oferta'])==1) {
			$desc = "0.0".$rp['oferta'];
	}else{
			$desc = "0.".$rp['oferta'];
		}
		$precio_total = $rp['precio_unidad'] - ($rp['precio_unidad'] * $desc);
	}else{
		$precio_total = $rp['precio_unidad'];
	}

		$monto = $precio_total*$r2['cantidad'];

		$mysqli->query("INSERT INTO detalleventa (folio_v, codigo_barras, talla, cantidad, subtotal) VALUES ('$ultima_venta','".$r2['codigo_barras']."', '".$r2['talla']."','".$r2['cantidad']."','$monto')");
        
        $t = $r2['talla'];
        $c = $r2['cantidad'];
        $cb = $r2['codigo_barras'];
	
        $mysqli->query("UPDATE inventario SET $t = $t - $c WHERE codigo_barras = '$cb'");
        
        

	}


	$mysqli->query("DELETE FROM carrito WHERE id_cliente = '$id_cliente'");
	alert("Compra realizada");
    redir("?p=inicio");
}
?>



<h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-shopping-cart"></i> Carrito de compras</h1>
<br>

<table class="table table-striped">
	<tr style="color: #553F10">
		<th><i class="fa fa-image"></i></th>
		<th>Descripción</th>
		<th>Talla</th>
		<th>Cantidad</th>
		<th>Precio unitario</th>
		<th>Oferta</th>
		<th>Subtotal c/descuento</th>
		<th>Acciones</th>
	</tr>
<?php
	$id_cliente = clear($_SESSION['id_cliente']);
	$q = $mysqli->query("SELECT * FROM carrito WHERE id_cliente = $id_cliente");
	$monto_total = 0;

while ($r = mysqli_fetch_array($q)) {
	$q2 = $mysqli->query("SELECT * FROM inventario WHERE codigo_barras = '".$r['codigo_barras']."'");
	$r2 = mysqli_fetch_array($q2);

	$precio_total = 0;

	if ($r2['oferta']>0) {
		if (strlen($r2['oferta'])==1) {
			$desc = "0.0".$r2['oferta'];
		}else{
			$desc = "0.".$r2['oferta'];
		}
		$precio_total = $r2['precio_unidad'] - ($r2['precio_unidad'] * $desc);
	}else{
		$precio_total = $r2['precio_unidad'];
	}

	$descripcion = $r2['descripcion'];
    $talla = $r['talla'];
    if($talla == "chica_exist"){
        $talladesc = "Chica";
    }
    if($talla == "med_exist"){
        $talladesc = "Mediana";
    }
    if($talla == "gde_exist"){
        $talladesc = "Grande";
    }
	$cantidad = $r['cantidad'];
	$p_unitario = $precio_total;
	$subtotal = $cantidad*$precio_total;
	$imagen_producto = $r2['imagen'];

	$monto_total = $monto_total + $subtotal;

	?>
		<tr>
			<td><img src="productos/<?=$imagen_producto?>" class="imagen_carro"/></td>
			<td><?=$descripcion?></td>
			<td><?=$talladesc?></td>
			<td><?=$cantidad?> </td>
			<td>$ <?=$p_unitario?> <?=$divisa?></td>
			<td>
				<?php
					if ($r2['oferta']) {
						echo $r2['oferta']."% de Descuento";
					}else{
						echo "Sin Descuento";
					}
				?>
			</td>
			<td style="font-weight: bold; ">$ <?=$subtotal?> <?=$divisa?></td>
			<td>
				<a onclick="modificar(<?=$r['folio']?>)" href="#"><i style="color: #553F10;" class="fa fa-edit" title="Modificar" ></i></a>
				&nbsp;
				<a href="?p=carrito&eliminar=<?=$r['folio']?>"><i style="color: #553F10;" class="fa fa-times" title="Eliminar" ></i></a>
				&nbsp;
			</td>
		</tr>
	<?php
	}
}else{
	redir("?p=login&return=carrito");
}
	?>	

</table>

<h2>Monto Total: <b class="text_cafe">$ <?=$monto_total?> <?=$divisa?></b></h2>


<br>
	<form method="post" action="">
		<input type="hidden" name="monto_total" value="<?=$monto_total?>" />
		<button class="btn btn-primary" style="background: #553F10; border: #0a0a0a;" type="submit" name="finalizar"><i class="fa fa-check"></i>Finalizar Compra</button>
	</form>


<script type="text/javascript">
	
	function modificar(cod){
		var new_cant = prompt("Ingrese la nueva cantidad");

		if (new_cant>0) {
			window.location="?p=carrito&cod="+cod+"&modificar="+new_cant;
		}

	}



</script>