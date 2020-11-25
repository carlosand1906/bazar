<?php
	if (isset($_SESSION['id_cliente'])) {

		$s = $mysqli->query("SELECT * FROM venta WHERE id_cliente = '".$_SESSION['id_cliente']."' ORDER BY fecha DESC");
	if (mysqli_num_rows($s)>0) {
		?>
        <h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-tasks"></i> Mis Compras</h1>

			<table class="table tale-stripe">
				<tr style="color: #553F10">
					<th>Folio</th>
					<th>Fecha</th>
					<th>Hora</th>
					<th>Total</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
<?php
			while ($r = mysqli_fetch_array($s)) {
?>
				<tr>
					<td><?=$r['folio_v']?></td>
					<td><?=fecha($r['fecha'])?></td>
					<td><?=$r['hora']?></td>
					<td>$ <?=$r['total']?> <?=$divisa?></td>
					<td><?=estado($r['estado'])?></td>
					<td>
						<a href="?p=comprobante&folio=<?=$r['folio_v']?>">
							<i style="color: #553F10" class="fa fa-eye"></i>
						</a>
					</td>
				</tr>
<?php
		}
?>


			</table>


		<?php
	}else{
		?>
			<h1 style="color: #553F10" aria-hidden="true"><i class="fa fa-money"></i> El usuario aun no ha comprado nada</h1>
<?php
	}

}else{
	redir("?p=login&return=mis_compras");
}
?>