<br>
<h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-tags"></i> Mejores ofertas</h1>
<br>
<br>

<select style="width: 30%" id="categoria" onchange="redir_cat()" class="form-control">
	<option value="">Seleccione una categoria para filtrar</option>
	<?php
		$cats = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");
		while ($rcat = mysqli_fetch_array($cats)) {
	?>
		<option value="<?=$rcat['id_categoria']?>"><?=$rcat['categoria']?></option>
	<?php
		}
	?>
</select>
<br>
<?php
		if (isset($cat)) {
			$sc = $mysqli->query("SELECT * FROM categorias WHERE id_categoria = '$cat'");
			$rc = mysqli_fetch_array($sc);
			$resp = $rc['categoria'];
			?>
			<h1>Productos filtrados por: <?=$resp?></h1>
<?php
		}else{
            ?>
            <?php
        }


	if (isset($cat)) {
		$q = $mysqli->query("SELECT * FROM inventario WHERE categoria = '$cat' AND oferta > 0");
	}else{
		$q = $mysqli->query("SELECT * FROM inventario WHERE oferta > 0 ORDER BY oferta DESC");
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
		<del>$ <?=$r['precio_unidad']?> <?=$divisa?></del> <span class="precio">   $ <?=$precio_total?> <?=$divisa?></span>
	</div>
<?php
}
?>

	<script type="text/javascript">
		function agregar_carro(codigo){
					window.location="?p=elegir_talla&agregar="+codigo;
		}
        
		function redir_cat(){
			window.location="?p=ofertas&cat="+$("#categoria").val();
		}


	</script>