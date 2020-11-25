<br>
<h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-book"></i> Catalogo</h1>
<br>
<br>

<?php
	$q = $mysqli->query("SELECT * FROM inventario");
?>

<?php
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