
<br>
<h1 style="color: #553F10"><i class="fa fa-shopping-bag"></i>Ultimos Productos Agregados</h1>
<br>
<br>
<?php
	$q = $mysqli->query("SELECT * FROM inventario WHERE oferta > 0 ORDER BY chica_exist DESC LIMIT 3");

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
		<div><img class="img_producto" src="productos/<?=$r['imagen']?>"></div>
		<del>$ <?=$r['precio_unidad']?> <?=$divisa?></del><span class="precio">$ <?=$precio_total?> <?=$divisa?></span>
	</div>
<?php
	}
?>
<script type="text/javascript">
	function agregar_carro(codigo){
		window.location="?p=elegir_talla&agregar="+codigo;
}
</script>