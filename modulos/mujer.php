<br>
<h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-female"></i> Catalogo para Mujeres</h1>
<br>
<br>
    

<?php
		if (isset($agregar) && isset($cant)) {


		if (!isset($_SESSION['id_cliente'])) {
			alert("Inicie sesión antes de comenzar la compra");
			redir("?p=login");
		}
		
		$codigo = clear($agregar);
		$cant = clear($cant);
		$id_cliente = clear($_SESSION['id_cliente']);

	$v = $mysqli->query("SELECT * FROM carrito WHERE id_cliente = '$id_cliente' AND codigo_barras = '$codigo'");

		if (mysqli_num_rows($v)>0) {

	$q = $mysqli->query("UPDATE carrito SET cantidad = cantidad + $cant WHERE id_cliente = '$id_cliente' AND codigo_barras = '$codigo'");



		}else{


	$q = $mysqli->query("INSERT INTO carrito (id_cliente, codigo_barras, cantidad) VALUES ('$id_cliente','$codigo','$cant')");



}
		alert("Se ha agregado al carrito");
		redir("?p=inicio");

}



		$q = $mysqli->query("SELECT * FROM inventario WHERE catalogo = 'Mujer'");
	

?>


<?php

	if(isset($cat) && isset($busqueda)) {
		?>
		<h1>Resultados <?=$busqueda?></h1>
		<?php
	}elseif (isset($cat) && !isset($busqueda)) {
		?>
		<h1>Resultados <?=$cat?></h1>
		<?php
	}elseif (!isset($cat) && isset($busqueda)) {
		?>
		<h1>Resultados <?=$busqueda?></h1>
		<?php		
	}elseif (!isset($cat) && !isset($busqueda)) {
		
	}

	

	while ($r = mysqli_fetch_array($q)) {

		$precio_total = 0;

	if ($r['oferta']>0) {
		if (strlen($r['oferta'])==1) {
			$desc = "0.0".$r['oferta'];
		}else{
			$desc = "0.".$r['oferta'];
		}
		$precio_total = $r['precio_unidad'] - ($r['precio_unidad'] * $desc);
	}else{
		$precio_total = $r['precio_unidad'];
	}


?>
	<div class="producto" onclick="agregar_carro('<?=$r['codigo_barras']?>')">
		<div class="desc_producto"><?=$r['descripcion']?></div>
		<div><img class="img_producto" src="productos/<?=$r['imagen']?>"/></div>
	<?php
		if ($r['oferta']>0) {
	?>
			<del>$ <?=$r['precio_unidad']?> <?=$divisa?></del> <span class="precio"> $ <?=$precio_total?> <?=$divisa?></span>
	<?php		
		}else{
	?>
		<span class="precio"> $ <?=$r['precio_unidad']?> <?=$divisa?></span>
	<?php
		}
	?>

	</div>
<?php
}
?>

	<script type="text/javascript">
		function agregar_carro(codigo){
					window.location="?p=elegir_talla&agregar="+codigo;
		}



	</script>